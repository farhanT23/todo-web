<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registration(){
        return view('auth.registration');
    }

    public function showLoginForm(){
        return view('auth.login');
    }

    public function newPassword(){
        return view('auth.newPassword');
    }

    public function forgetPassword(){
        return view('auth.forgetPassword');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // check is_active
            if (!Auth::user()->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is not active.']);
            }

            //check if the user is verified
            if (!Auth::user()->is_verified) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is not verified.']);
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
