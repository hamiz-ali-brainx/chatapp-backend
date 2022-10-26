<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Jobs\SendPasswordResetEmailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{


    public function forgotPasswordForm(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
        $token = Str::random(64);
         PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::Now()
        ]);
         $details =[
             'email'=>$request->email,
             'token'=>$token
         ];
         SendPasswordResetEmailJob::dispatch($details);
//        dispatch(new SendPasswordResetEmailJob($details));
        $message = "Password Reset has been sent. Check your inbox for email";
        $response = [
            'message' => $message,
        ];

        return response()->json(
            $response,
            200
        );
    }

    public function resetPassword(Request $request, $token){
        $request->validate([
            'password' => 'required|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required'
        ]);


        $updatePassword = PasswordReset::where('token', $token)->first();
        if(!$updatePassword){
            $message = "This Link is expired";
            $response = [
                'error' => $message,
            ];

            return response()->json(
                $response,
                400
            );
        }
        $user = User::where('email', $updatePassword->email)->update(['password'=>Hash::make($request->password)]);

        PasswordReset::where('email', $updatePassword->email)->delete();
        $message = "Password Updated";
        $response = [
            'message' => $message,
        ];
          return response()->json(
            $response,
            200
        );

    }
}
