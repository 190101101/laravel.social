<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();

        if( !$user ){ abort(404); }

        $statuses = $user->statuses()->notReply()->paginate(1);

        return view('profile.index', [
            'user' => $user,
            'statuses' => $statuses,
            'authUserIsFriend' => Auth::user()->isFriendWith($user)
        ]);
    }

    public function getEdit()
    {
        return view('profile.edit');
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'bail|required|alpha|min:3|max:30',
            'lastname' => 'bail|required|alpha|min:3|max:30',
            'location' => 'bail|required|alpha|min:3|max:30',
        ]);

        User::where('id', Auth::user()->id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'location' => $request->location,
        ]);

        return redirect()->route('profile.edit')->with('info', 'profile updated');
    }
}
