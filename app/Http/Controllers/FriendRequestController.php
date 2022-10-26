<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\UserFriend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function sendRequest(Request $request, $to)
    {
        UserFriend::create([
            "user_id" => Auth::user()->id,
            "friends_id" => $to,
            "status" => "Pending"
        ]);

        $message = "Request Sent.";
        $response = [
            'message' => $message,
        ];

        return response()->json(
            $response,
            200

        );

    }

    public function getAllSentRequests(Request $request)
    {

        $user = User::with(['friendsTo' => function ($query) {
            $query->where('status', 'Pending');
        }])->where("id", Auth::user()->id)->first();


        $response = [
            'sent_requests' => $user->friendsTo,
        ];

        return response()->json(
            $response,
            200
        );

    }

    public function getAllReceivedRequests(Request $request)
    {
        $user = User::with(['friendsFrom' => function ($query) {
            $query->where('status', 'Pending');
        }])->where("id", Auth::user()->id)->first();


        $response = [
            'received_requests' => $user->friendsFrom,
        ];
        return response()->json($response, 200);
    }
    public function getAllFriends(Request $response){
//        $allFriends = UserFriend::where([
//            [ 'user_id', '=', Auth::user()->id ],
//            ['status', 'Accepted']
//
//        ])->orWhere([
//            [ 'friends_id', '=', Auth::user()->id ],['status', 'Accepted']
//        ])->get();
        $friends = User::with(['friendsTo' => function($query){
            $query->where('status', 'Accepted');
        }, 'friendsFrom'=>function($query){
            $query->where('status', 'Accepted');
        }])->where("id", Auth::user()->id)->first();

        $response = [
            'message' => $friends,
        ];

        return response()->json(
            $response,
            200
        );
    }
    public function acceptrequest(Request $request, $from)
    {

        $accept_request = UserFriend::where([['user_id', $from], ['friends_id',Auth::user()->id]])->orWhere([['user_id', Auth::user()->id], ['friends_id',$from]])->first();
        $accept_request->status = "Accepted";
        $accept_request->save();
        $response = [
            'message' => "Request Accepted",
        ];

        return response()->json(
            $response,
            200
        );
    }
}
