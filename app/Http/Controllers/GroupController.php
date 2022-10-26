<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\UserGroup;
use App\Notifications\GroupCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class GroupController extends Controller
{
    public function createGroup(Request $request)
    {
       $request->validate([
            'name' => 'required',
            'users'=> 'required|array|min:3'
        ]);
        $group = Group::create([
            "name" => $request->name,
        ]);

        UserGroup::create([
           "user_id"=> Auth::user()->id,
           "groups_id"=>$group->id,
           "status"=>"Accepted"
        ]);
        foreach($request->users as $user){
                UserGroup::create([
                    'user_id' => $user['id'],
                    'groups_id'=> $group->id,
                    'status'=> 'Rejected'
                ]);
                $user = User::where('id', $user['id'])->first();
                $details = [
                    'greeting' => 'Hi ' . $user->name,
                    'body' => 'You were added to a group '. $request->name,
                    'actionText' => 'Visit My Site',
                    'actionURL' => url('/'),
                ];
                Notification::send($user, new GroupCreated($details));
        }

        $message = "Group Created.";
        $response = [
            'message' => $message,
        ];

        return response()->json(
            $response,
            200

        );

    }

    public function getGroups(Request $request){
        $user = User::with(['userGroups'])->where("id", Auth::user()->id)->first();
        $response = [
            'Groups' => $user->userGroups,
        ];

        return response()->json(
            $response,
            200
        );
    }


}
