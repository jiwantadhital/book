<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\students;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function sendSmsNotificaition($number , $otp)
    {
        $basic  = new \Vonage\Client\Credentials\Basic("0a2b65fa", "BdI7Z4463UWJp12W");
        $client = new \Vonage\Client($basic);
 
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("977$number","9779746459220", "Your otp for BIM Notes is $otp")
        );
        $message = $response->current();
        if ($message->getStatus() == 0) {
            return response()->json([
                'message' => "Sucessful"
            ]);
        } else {
            return response()->json([
                'message' => "Failed"
            ]);
        }
    }
   
    public function basic_email($otp, $emai) {
        try{
        Mail::raw("your otp is $otp", function($message) use ($emai){
            $message->to($emai)
                    ->subject("Your otp code");
        });
        return response()->json([
            'message' => "Sucessful"
        ]);
    }
    catch(Exception $e){
        return response()->json([
            'message' => "Failed"
        ]);
    }
     }
//google
public function requestTokenGoogle(Request $request) {
    // // Getting the user from socialite using token from google
    $usrdata = Socialite::driver('google')->stateless()->userFromToken($request->token);
    $theEmail = $usrdata->email;
    $theName = $usrdata->name;
    $emailExists = User::where('email', $usrdata->email)
            ->exists();
    if($emailExists==true){
   $user = User::where('email', $theEmail)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        $userde=$user->id;

    // Check if the user is already logged in on another device
    $existingDeviceToken = User::where('id', '<>', $user->id)
                               ->where('device_token', $request->input('device_token'))
                               ->value('device_token');

    if ($existingDeviceToken) {
        // If user is already logged in on another device, log them out
        User::where('device_token', $existingDeviceToken)
            ->update(['device_token' => null]);
    }

    // Update user's device token
    $user->device_token = $request->input('device_token');
    $user->last_login = now();
    $user->save();
        $student = students::where('user_id', $userde)->first();
        return response()->json([
            'token' => $token,
            'payment' => $student->payment,
            'message' => "successfull",
            "time" => false,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'phone_verified' => $user->phone_verified,
            'user_email' => $user->email
        ]);
    }
    else{
        $randomId =   rand(1000,9999);
        $paymentN = 1;
        $current_time = \Carbon\Carbon::now()->toDateTimeString();
        $user = User::create([
            'name' => $theName,
            'email' => $theEmail,
            'email_verified_at' => $current_time,
            'phone_verified'=> 1
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        $student = students::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'otp' => $randomId,
            'payment' => 1
        ]);
        // $this->sendSmsNotificaition($request->phone, $randomId);
        return response()->json([
        'token' => $token,
        'payment' => $paymentN,
        'message' => "successfull",
        "time" => true,
        'user_id' => $user->id,
        'user_name' => $student->name,
        'phone_verified' => $user->phone_verified,
        'user_email' => $user->email
        ]);
    }

    // // Returning response
    // $token = $userFromDb->createToken('Laravel Sanctum Client')->plainTextToken;
    // $response = ['token' => $token, 'message' => 'Google Login/Signup Successful'];
    // return response($response, 200);
}


    public function register(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:10',
            // 'phone' => 'required|unique:students',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            $formatted_error = $errors->first();
            return response()->json([
                'message' => $formatted_error
            ], 400);
        }
        // Check if validation pass then create user and auth token. Return the auth token
        if ($validator->passes()) {
            $randomId =   rand(1000,9999);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_verified'=> 0,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            $student = students::create([
                'otp' => $randomId,
                'user_id' => $user->id,
                'name' => $user->name,
                'phone' => $request->phone,
                'payment' => 1  
            ]);
                    //  $this->sendSmsNotificaition($student->phone,$student->otp);
            
            $this->basic_email($randomId,$request->email);
            return response()->json([
            'token' => $token,
            'payment' => $student->payment,
            'otp' => $randomId,
            'student' => $student->name,
            'message' => "successfull",
            'user_id' => $user->id,
            'phone_verified' => $user->phone_verified,
            'user_email' => $user->email
            ]);
        }
        else{
            return response()->json([
                'message' => "failed",
                ]);
            }
        }
        
        //send otp
        public function sendOtp(Request $request){
            $emailExists = User::where('email', $request->email)
            ->exists();
            if($emailExists == true){
            $id = User::where('email', $request->email)->pluck('id')->first();
            $student = students::where('user_id', $id)->first();
            $this->basic_email($student->otp,$request->email);
            return response()->json([
                'otp' => $student->otp,
                'success' => true,        
                ]);
            }
            else{
                return response()->json([
                    'success' => false,        
                    ]);
            }
        }

         //resend otp
         public function resedOtp(Request $request){
            $id = User::where('email', $request->email)->pluck('id')->first();
            $student = students::where('user_id', $id)->first();
            $this->basic_email($student->otp,$request->email);
            return response()->json([
                'success' => true,        
                ]);
        }

        //changePassword
        public function changePassword(Request $request){
            try{
                $change = User::where('email', $request->email)->first();
            $change->password = Hash::make($request->password);
            $change->save();
            return response()->json([
                'success' => true,        
                ]);
            }
            catch(e){
                return response()->json([
                    'success' => false,        
                    ]);
            }
        }


     //edit profile
     public function editProfile(Request $request,$id){
        try{
            $verify = students::where('user_id','=',$id);
            $verify->update($request->all());
            $verif=User::find($id);
            $verif->name = $request->name;
            $verif->save();
            return response()->json([
                'success' => true,        
                ]);
            }
            catch(e){
                return response()->json([
     
                    'success' => false,        
                    ]);
                }
            }
            
    //getprofile
    public function getProfile(Request $request,$id)
{
        $data = students::where('user_id','=',$id)->with('User')->with('Semester')->get();
        if (count($data) > 0) {
            return response()->json($data[0]);
        } else {
            return response()->json([]);
        }
}
     
    public function updatePhone(Request $request,$id)
    {
        //
        $verify=User::find($id);
        $verify->phone_verified = 1;
        $verify->save();
        if($verify->phone_verified == 0){
            return response()->json([
     
                'message' => "failed",
        
                ]);
        }
        else if($verify->phone_verified == 1){
        return response()->json([
     
            'message' => "successfull",
            'verify' => $verify->phone_verified
    
            ]);
        }

    }

    //update payment
    public function updatePayment(Request $request,$id)
    {
        //
        $verify = students::where('user_id', $id)->firstOrFail();
        $verify->payment = 1;
        $verify->save();
        if($verify->payment == 0){
            return response()->json([
     
                'message' => "failed",
        
                ]);
        }
        else if($verify->payment == 1){
        return response()->json([
     
            'message' => "successfull",
            'verify' => $verify->payment
    
            ]);
        }

    }

    //login
    public function login(Request $request)
{
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Invalid login details'
        ], 400);
    }

    $user = User::where('email', $request['email'])->firstOrFail();
    $token = $user->createToken('auth_token')->plainTextToken;
    $userde = auth()->user()->id;

    // Check if the user is already logged in on another device
    $existingDeviceToken = User::where('id', '<>', $user->id)
                               ->where('device_token', $request->input('device_token'))
                               ->value('device_token');

    if ($existingDeviceToken) {
        // If user is already logged in on another device, log them out
        User::where('device_token', $existingDeviceToken)
            ->update(['device_token' => null]);
    }

    // Update user's device token
    $user->device_token = $request->input('device_token');
    $user->last_login = now();
    $user->save();

    $student = students::where('user_id', $userde)->first();
    if (auth()->user()->phone_verified == 0) {
        $this->basic_email($student->otp, auth()->user()->email);
    }

    return response()->json([
        'payment' => $student->payment,
        'otp' => $student->otp,
        'token' => $token,
        'message' => "successfull",
        'user_id' => auth()->user()->id,
        'user_name' => auth()->user()->name,
        'phone_verified' => auth()->user()->phone_verified,
        'user_email' => auth()->user()->email
    ]);
}

    // public function login(Request $request)
    // {

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json([
    //             'message' => 'Invalid login details'
    //         ], 400);
    //     }
    //     $user = User::where('email', $request['email'])->firstOrFail();
    //     $token = $user->createToken('auth_token')->plainTextToken;
    //     $userde=auth()->user()->id;
    //     $student = students::where('user_id', $userde)->first();
    //     if(auth()->user()->phone_verified == 0){
    //         $this->basic_email($student->otp,auth()->user()->email);
    // }
    // else{

    // }
    //     return response()->json([
    //         'payment' => $student->payment,
    //         'otp' => $student->otp,
    //         'token' => $token,
    //         'message' => "successfull",
    //         'user_id' => auth()->user()->id,
    //         'user_name' => auth()->user()->name,
    //         'phone_verified' => auth()->user()->phone_verified,
    //         'user_email' => auth()->user()->email
    //     ]);
    
    // }
}
