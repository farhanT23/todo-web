@extends('layouts.guest')

@section('content')
    <div class="border border-gray-200 w-1/4  mx-auto px-10 py-5 rounded">

        <h1 class="text-2xl font-bold text-center mb-5">Register</h1>

        <form class="w-full">

            <x-input name="name" label="Your Name" type="name" />
            <x-input name="email" label="Your email" type="email" />
            <x-input name="password" label="Your password" type="password" />
            <x-input name="password_confirmation" label="Confirm password" type="password" />

            <x-button type="submit" class="w-full mt-5">
                Register
            </x-button>

            @if (Route::has('login'))
                <p class="text-sm font-light text-gray-500 mt-5 text-center">
                    Already have an account? <a href="{{ route('login') }}"
                        class="font-medium text-blue-600 hover:underline">Login</a>
                </p>
            @endif

        </form>
    </div>
@endsection
