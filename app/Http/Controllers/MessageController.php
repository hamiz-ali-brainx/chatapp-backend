<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function sendMessage(Request $request){
      $validated =  $request->validate([
            'text' => 'required',
            'receiver_id'=> 'required|integer'
        ]);
        Message::create([
            'body'=>$request->text,
            'sender_id'=>Auth::user()->id,
            'receiver_id'=>$request->receiver_id
        ]);
        $message = 'sent';
        $response = [
            'message' => $message,
        ];
        return response()->json([
            $response
        ], 200);
    }

    public function readMessage(Request $request, $id){
        $message = Message::where('id', $id)->first();
        $message->read_at = Carbon::now();
        $message->save();
        $response = [
            'message' => "Message Read",
        ];
        return response()->json([
            $response
        ], 200);
    }
    public function sendGroupMessage(Request $request){
        $request->validate([
            'text' => 'required'
        ]);
        Message::create([
            'body'=>$request->text,
            'sender_id'=>Auth::user()->id,
            'group_id'=>$request->group_id
        ]);
        $message = 'sent';
        $response = [
            'message' => $message,
        ];
        return response()->json([
            $response
        ], 200);
    }
    public function getGroupConversation(Request $request, $group){
        $existingConversation = Message::where(
             'group_id', $group
        )
        ->orderBy('created_at', 'asc')->get();



        $response = [
            'message' => $existingConversation,
        ];
        return response()->json([
            $response
        ], 200);
    }
    public function getConversation(Request $request, $with){
        $existingConversation = Message::where([
            [ 'sender_id', '=', Auth::user()->id ],
            [ 'receiver_id', '=', $with ]
        ])->orWhere([
            [ 'sender_id', '=', $with ],
            [ 'receiver_id', '=', Auth::user()->id ]
        ])->orderBy('created_at', 'asc')->get();
        $response = [
            'message' => $existingConversation,
        ];
        return response()->json([
            $response
        ], 200);
    }
}
