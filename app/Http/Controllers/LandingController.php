<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function showGreeting()
    {
        $hour = date('H');
        if ($hour < 12) {
            $greeting = 'Good morning!';
        } elseif ($hour < 18) {
            $greeting = 'Good afternoon!';
        } else {
            $greeting = 'Good evening!';
        }

        return view('landing', compact( 'greeting'));
    }
}
