<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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


    public function login(){
        return view('auth.login');
    }

    public function newPassword(){
        return view('auth.newPassword');
    }

    public function forgetPassword(){
        return view('auth.forgetPassword');
    }
}