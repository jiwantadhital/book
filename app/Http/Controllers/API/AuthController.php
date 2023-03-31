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
        return response()->json([
            'token' => $token,
            'message' => "successfull",
            "time" => false,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'phone_verified' => $user->phone_verified,
            'user_email' => $user->email
        ]);
    }
    else{
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
            'name' => $user->name
        ]);
        // $this->sendSmsNotificaition($request->phone, $randomId);
        return response()->json([
        'token' => $token,
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
            return response()->json([
                'message' => $errors
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
                'phone' => $request->phone
            ]);
                    //  $this->sendSmsNotificaition($student->phone,$student->otp);
            
            $this->basic_email($randomId,$request->email);
            return response()->json([
            'token' => $token,
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
            'verify' => $request->phone_verified
    
            ]);
        }

    }

    //login
    public function login(Request $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        $userde=auth()->user()->id;
        $student = students::where('user_id', $userde)->first();
        if(auth()->user()->phone_verified == 0){
            $this->basic_email($student->otp,auth()->user()->email);
    }
    else{

    }
        return response()->json([
            'otp' => $student->otp,
            'token' => $token,
            'message' => "successfull",
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
            'phone_verified' => auth()->user()->phone_verified,
            'user_email' => auth()->user()->email
        ]);
    
    }
}
