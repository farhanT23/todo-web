@extends('layouts.guest')

@section('content')
    <div class="border border-gray-200 w-1/4  mx-auto px-10 py-5 rounded">

        <h1 class="text-2xl font-bold text-center mb-5">Login</h1>

        <form class="w-full">

            <x-input name="email" label="Your email" type="email" />
            <x-input name="password" label="Your password" type="password" />

            <a href="{{route('forget-password')}}" class="text-gray-700">Forgot Your Passowrd?</a>
            <x-button type="submit" class="w-full mt-5">
                Login
            </x-button>
        </form>
    </div>
@endsection
