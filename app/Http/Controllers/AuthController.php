<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class AuthController extends Controller
{
    public function getSignup()
    {
        return view('auth.signup');
    }

    public function PostSignUp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users|email|max:50',
            'username' => 'required|unique:users|alpha_dash|max:25|min:3',
            'password' => 'required|min:3|max:25',
        ]);

        User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('home')
            ->with('info', 'registered succesfully');
    }

    public function getSignin()
    {
        return view('auth.signin');
    }

    public function PostSignin(Request $request)
    {
        $request->flash();
        
        $this->validate($request, [
            'email' => 'required|email|max:50',
            'password' => 'required|min:3|max:25',
        ]);

        if(!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))){
            return redirect()->back()->with('info', 'user not found');
        }

        return redirect()->route('home')->with('info', 'you are login');
    }

    public function signout()
    {
        Auth::logout();
        return redirect()->route('home')->with('info', 'you are logouted');
    }


}
