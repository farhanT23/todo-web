@extends('layouts.guest')

@section('content')
    <div class="border border-gray-200 w-1/4  mx-auto px-10 py-5 rounded">

        <h1 class="text-2xl font-bold text-center mb-5">Email To Send Reset Link</h1>

        <form class="w-full" method="POST" action="{{ route('forget-password') }}">
            @csrf

            <x-input name="email" label="Your email" type="email" />

            <x-button type="submit" class="w-full mt-5">
                Submit
            </x-button>
        </form>

    </div>
@endsection
