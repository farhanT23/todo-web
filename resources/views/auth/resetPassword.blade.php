@extends('layouts.guest')

@section('content')
    <div class="border border-gray-200 w-1/4  mx-auto px-10 py-5 rounded">

        <h1 class="text-2xl font-bold text-center mb-5">Reset Your Password</h1>

        <form class="w-full" method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Hidden Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">
            <!-- Email Field (optional, sometimes passed via URL or hidden) -->
            <x-input name="email" label="Your Email" type="email" :value="old('email', request('email'))" />

            <x-input name="password" label="New Password" type="password" />
            <x-input name="password_confirmation" label="Confirm Password" type="password" />

            <x-button type="submit" class="w-full mt-5">
                Submit
            </x-button>
        </form>

        @if($errors->any())
            <div class="text-red-600 mt-4">
                {{ $errors->first() }}
            </div>
        @endif

    </div>
@endsection
