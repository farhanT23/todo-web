<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ config('app.name', 'Laravel') }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-sky-400 min-h-screen flex items-center justify-center">

<div class="bg-white rounded-2xl shadow-xl p-8 text-center w-80">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{$greeting}}</h1>
    <div class="space-y-4">
        @if(Route::has('login'))
            <a href="{{route('login')}}" class="block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Login</a>
        @endif
        @if(Route::has('registration'))
                <a href="{{route('registration')}}" class="block bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition">Register</a>
        @endif

    </div>
</div>

</body>
