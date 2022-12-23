<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\Status;
use App\models\User;
use App\models\Like;

class StatusController extends Controller
{
    public function postStatus(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|min:3|max:200',
        ]);

        Auth::user()->statuses()->create([
            'body' => $request->body
        ]);

        return redirect()->route('home')->with('info', 'created succesfully');
    }

    public function postReply(Request $request, $statusId)
    {
        $this->validate($request, [
            "reply-{$statusId}" => 'required|min:3|max:200'
        ]);

        $status = Status::notReply()->find($statusId);
        
        if(!$status) redirect()->route('home');

        if(!Auth::user()->isFriendWith($status->user) && 
            Auth::user()->id !== $status->user->id){
            return redirect()->route('home');
        }

        $reply = new Status();
        $reply->body = $request->input("reply-{$status->id}");
        $reply->user()->associate(Auth::user());
        
        $status->replies()->save($reply);
        return redirect()->back();
    }

    public function getLike($statusId)
    {
        $status = Status::find($statusId);

        if(!$status) redirect()->route('home');

        if(!Auth::user()->isFriendWith($status->user)){
            return redirect()->route('home');
        }

        if(Auth::user()->hasLikedStatus($status)){
            return redirect()->back();
        }

        $status->likes()->create(['user_id' => Auth::user()->id]);

        return redirect()->back();
    }
}
