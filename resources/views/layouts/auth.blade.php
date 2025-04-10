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
    @vite(['resources/css/app.css'])

</head>

<body class="flex justify-center items-center h-screen">
    <div class="block w-full h-screen">
        <nav class="bg-blue-200 h-10">
            <div class="flex flex-row justify-between items-center h-full px-4">
                <div class="flex flex-row items-center gap-2">
                    <div onclick="toggleSidebar()"
                        class="cursor-pointer hover:bg-blue-300 rounded-full p-1 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </div>
                    <div>
                        Todo List
                    </div>
                </div>
                <div>
                    <div class="flex flex-row items-center gap-2">
                        <form>
                            <input name="search" type="text" class="border border-gray-400 rounded px-2 py-1"
                                placeholder="Search...">
                            <button class="px-2 py-1 rounded bg-blue-600 text-white">Search</button>
                        </form>
                    </div>
                </div>
                <div class="flex flex-row items-center gap-2">
                    <div>Profile</div>
                    <a class="px-5 py-1 rounded bg-red-400 text-white" href="#">
                        Logout

                    </a>

                </div>
            </div>
        </nav>
        <div class="flex flex-row h-[calc(100vh-2.5rem)] ">
            <x-sidebar />
            <div class="w-full bg-blue-50 px-10 py-2">
                @yield('content')
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')

</body>

</html>
