<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginStoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;




class SessionsController extends Controller
{
    //login view
    public function create()
    {
        return view('sessions.login');
    }

    public function getAllUsers(Request $request){
        $users = User::all();

        return response()->json([
           'users'=>$users,
        ], 200);
    }

    //authorize user from the database
    public function store(LoginStoreRequest $request)
    {

        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();

        if (Auth::attempt($validated)) {

                $message = 'Great! You have Successfully LoggedIn';
                $response = [
                    'message' => $message,
                    'user'=>$user,
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ];
                return response()->json([
                    $response
                ], 200);
            //}
        }
        $error = "Invalid Credentials";
        $response = [
            'error' => $error
        ];
        return  response()->json($response,401);
    }

    //logout user

    public function destroy()
    {

        Auth::guard('web')->logout();
        $message = "Logout";
        $response = [
            'message' => $message
        ];
        return  response()->json($response);
    }
    }

