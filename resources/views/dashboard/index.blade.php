@extends('layouts.auth')

@section('content')
    <div class="flex flex-row justify-between items-center mb-10">
        <h1 class="text-2xl font-bold">All Task</h1>
        <button class="px-5 py-1 rounded bg-blue-600 text-white">Add Task</button>
    </div>

    <div class="px-10">
        <form class="flex flex-row gap-2 mb-5">
            <input name="from_date" type="date" value="{{ request()->from_date }}"
                class="border border-gray-400 rounded px-2 py-1">
            <input name="to_date" type="date" value="{{ request()->to_date }}"
                class="border border-gray-400 rounded px-2 py-1">

            <select name="priority" class="border border-gray-400 rounded px-2 py-1">
                <option value="">Select Priority</option>

                @foreach (['low', 'medium', 'high'] as $priority)
                    <option value="{{ $priority }}" @if (request()->priority == $priority) selected @endif>
                        {{ ucfirst($priority) }}</option>
                @endforeach

            </select>
            <button class="px-2 py-1 rounded bg-blue-600 text-white">Search</button>

        </form>
    </div>

    <div id="task-grid"
        class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 h-[calc(100vh-10rem)] overflow-y-auto relative px-10">

        <div id="scroll-sentinel" class="h-1 col-span-full z-10"></div>

        <!-- Place spinner after sentinel to avoid intersection issues -->
        <div id="loading-spinner" class="absolute inset-x-0 bottom-2 flex justify-center hidden">
            <div class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        let currentPage = 1;
        let lastPage = 1;
        let isLoading = false;

        let observer;

        function loadTasks(page = 1, append = false) {
            if (isLoading) return;
            isLoading = true;

            const spinner = document.querySelector('#loading-spinner');
            spinner.classList.remove('hidden');

            //get query params
            const urlParams = new URLSearchParams(window.location.search);

            const search = urlParams.get('search') || '';
            const starred = urlParams.get('starred') || '';
            const completed = urlParams.get('completed') || '';
            const fromDate = urlParams.get('from_date') || '';
            const toDate = urlParams.get('to_date') || '';
            const priority = urlParams.get('priority') || '';

            fetch(
                    `/tasks?page=${page}&search=${search}&starred=${starred}&completed=${completed}&from_date=${fromDate}&to_date=${toDate}&priority=${priority}`
                )
                .then(response => response.json())
                .then(res => {
                    const taskContainer = document.querySelector('#task-grid');
                    const tasks = res.data.data;
                    lastPage = res.data.last_page;

                    if (!append) {
                        document.querySelectorAll('#task-grid > .task-item').forEach(el => el.remove());
                    }

                    tasks.forEach(task => {
                        const data = `
                    <div class="task-item border border-gray-300 rounded-lg p-4 bg-white shadow-md flex flex-col gap-2 ">
                        <div class="w-full">
                            <div class="flex justify-end gap-2">
                                <button class="px-1 py-1 text-blue-500 rounded cursor-pointer">
                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                </button>
                                <button onclick="return confirm('Are you sure to delete?');"
                                        class="px-1 py-1 text-red-500 rounded cursor-pointer">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                                <button class="px-1 py-1 bg-green-500 text-white rounded cursor-pointer">
                                    <x-heroicon-o-check class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <h1 class="font-bold">${task.title}</h1>
                        </div>
                        <div>${task.description}</div>
                        ${task.due_date ? `
                                                                                            <div id="due-date" class="flex items-center mt-auto">
                                                                                                <span class="text-gray-500 border border-gray-400 px-2 py-1 rounded-full shadow-2xl">
                                                                                                    ${new Date(task.due_date).toLocaleDateString('en-GB')}
                                                                                                </span>

                                        <span class="text-gray-500 border 
                                        
                                        ${task.priority == 'low' ? 'bg-green-200 border-green-500' : task.priority == 'medium' ? 'bg-yellow-200 border-yellow-500' : 'bg-red-200 border-red-500'}

                                        px-2 py-1 rounded-full shadow-2xl uppercase">
                                            ${task.priority}
                                        </span>
                                                                                            </div>` : ''
                        }
                        
                    </div>
                `;
                        const sentinel = document.querySelector('#scroll-sentinel');
                        if (sentinel) {
                            sentinel.insertAdjacentHTML('beforebegin', data);
                        } else {
                            taskContainer.insertAdjacentHTML('beforeend', data);
                        }
                    });

                    // Re-observe sentinel after DOM changes
                    const sentinel = document.querySelector('#scroll-sentinel');
                    if (sentinel && observer) {
                        observer.unobserve(sentinel);
                        observer.observe(sentinel);
                    }

                    isLoading = false;
                    spinner.classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error loading tasks:', error);
                    isLoading = false;
                    spinner.classList.add('hidden');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadTasks();

            const sentinel = document.querySelector('#scroll-sentinel');

            observer = new IntersectionObserver((entries) => {
                const entry = entries[0];
                if (entry.isIntersecting && currentPage < lastPage && !isLoading) {
                    currentPage++;
                    loadTasks(currentPage, true);
                }
            }, {
                root: document.querySelector('#task-grid'),
                rootMargin: '0px',
                threshold: 1.0
            });

            if (sentinel) {
                observer.observe(sentinel);
            }
        });
    </script>
@endpush
