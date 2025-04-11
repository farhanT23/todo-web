<div class="sidebar w-1/4 bg-blue-100 px-5 py-2">
    <ul class="flex flex-col gap-2 mt-5">
        <li @if (request()->routeIs('dashboard') && !request()->starred && !request()->complete) class="bg-blue-200 px-2 py-1 rounded" @endif><a
                href="{{ route('dashboard') }}">All Task</a></li>
        <li @if (request()->routeIs('dashboard') && request()->starred && !request()->complete) class="bg-blue-200 px-2 py-1 rounded" @endif><a
                href="{{ route('dashboard', ['starred' => 1]) }}">Starred Task</a></li>
        <li @if (request()->routeIs('dashboard') && !request()->starred && request()->complete) class="bg-blue-200 px-2 py-1 rounded" @endif><a
                href="{{ route('dashboard', ['complete' => 1]) }}">Completed Task</a></li>
    </ul>

</div>
