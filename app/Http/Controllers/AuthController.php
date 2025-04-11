<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\RegistrationRequest;

use App\Models\User;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function registration(){
        return view('auth.registration');
    }

    public function registrationSave(RegistrationRequest $request){
        
        //save to database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //genarate otp

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->save();

        //send verification email

        //encrypt otp
        $encryptedData = encrypt([
            'otp' => $otp,
            'email' => $request->email,
        ]);

        //send email
        Mail::send('emails.verify', ['token' => $encryptedData], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verify your email address');
        });


        return redirect()->route('login')->with('success', 'Registration successful. A email was sent to your email. Please check your email to verify.');
    }

    public function verifyEmail($otp){
        //decrypt otp
        try{
            $data = decrypt($otp);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Invalid OTP. Please try again.');
        }

        //check if otp is valid
        $user = User::where('email', $data['email'])->first();
        if($user->otp != $data['otp']){
            return redirect()->route('login')->with('error', 'Invalid OTP. Please try again.');
        }
        $user->otp = null;
        $user->is_verified = 1;
        $user->is_active = 1;
        $user->save();
        
        return redirect()->route('login')->with('success', 'Email verified successfully. You can now login.');
        
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


