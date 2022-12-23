<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FriendController extends Controller
{
    public function getIndex()
    {
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequest();

        return view('friends.index', [
            'friends' => $friends,
            'requests' => $requests,
        ]);
    }

    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();

        if(!$user){
            return redirect()->route('home')->with('info', 'user not found');
        }

        if(Auth::user()->id == $user->id){
            return redirect()->route('home')->with('info', 'oops');
        }

        if(Auth::user()->hasFriendRequestPending($user) ||
         $user->hasFriendRequestPending(Auth::user())){
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'friend sended');
        }

        if(Auth::user()->isFriendWith($user)){
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'friend already friend');
        }

        Auth::user()->addFriend($user);
        return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'friend sended');
    }

    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();

        if(!$user){
            return redirect()->route('home')->with('info', 'user not found');
        }

        if(!Auth::user()->hasFriendRequestReceived($user)){
            return redirect()->route('home');
        }

        Auth::user()->acceptFriendRequest($user);
        return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'friend added');
    }

    public function deleteFriend($username)
    {
        $user = User::where('username', $username)->first();

        if(!Auth::user()->isFriendWith($user)){
            return redirect()->back();
        }

        Auth::user()->deleteFriend($user);

        return redirect()->back()->with('info', 'friend deleted');
    }
}
