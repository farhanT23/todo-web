@extends('layouts.auth')
@section('content')
    <div class="flex flex-row justify-between items-center mb-10">
        <h1 class="text-2xl font-bold">All Task</h1>
        <button class="px-5 py-1 rounded bg-blue-600 text-white">Add Task</button>
    </div>
    <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <x-single-task />
        <x-single-task />
        <x-single-task />
        <x-single-task />
        <x-single-task />
        <x-single-task />
        <x-single-task />
        <x-single-task />
        <x-single-task />
    </div>
@endsection
