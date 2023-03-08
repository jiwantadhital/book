<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\students;
use Illuminate\Support\Facades\Auth;


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
            // $this->sendSmsNotificaition($request->phone, $randomId);
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
        //  $this->sendSmsNotificaition($student->phone,$student->otp);
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
