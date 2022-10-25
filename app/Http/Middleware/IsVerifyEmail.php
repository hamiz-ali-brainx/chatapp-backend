<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\SendEmailJob;
use App\Models\UserVerify;
use App\Models\User;




class IsVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $message = "User Doesn't Exists";
            $response = [
                'error' => $message,
            ];
           // ddd(!is_null($user->email_verified_at));
            return response()->json($response, 401);
        } else if(is_null($user->email_verified_at)) {

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

            $message = "Your Email is not verified! Check your inbox";
            $response = [
                'error' => $message,
            ];
            return response()->json($response, 401);
        }

        return $next($request);
    }
}
