<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationStoreRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class RegistrationController extends Controller
{


    // return registration view
    public function registration()
    {

        return view('auth.registration');
    }


    public function postRegistration(RegistrationStoreRequest $request)
    {
        $validated = $request->validated();



        $user = $this->create($validated);
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        $details = [
            'email' => $user->email,
            'token' => $token,
            'name'=>$user->name

        ];
        dispatch(new SendEmailJob($details));
        $message = "Registration Successfull. Check your inbox for email verification";
        $response = [
            'message' => $message,
        ];

        return response()->json(
            $response,
            200

        );
    }


    public function verification($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;

           // ddd();
            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = Carbon::now();
                $user->save();
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }




        return redirect(env("CLIENT_URL")."login")->with('message', $message);
    }

    //create user
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }
}
