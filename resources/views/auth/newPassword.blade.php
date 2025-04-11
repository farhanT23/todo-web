@extends('layouts.guest')

@section('content')
    <div class="border border-gray-200 w-1/4  mx-auto px-10 py-5 rounded">

        <h1 class="text-2xl font-bold text-center mb-5">Reset Your Password</h1>

        <form class="w-full">
            <x-input name="password" label="Your password" type="password" />
            <x-input name="password_confirmation" label="Confirm password" type="password" />

            <x-button type="submit" class="w-full mt-5">
                Submit
            </x-button>
        </form>

    </div>
@endsection
