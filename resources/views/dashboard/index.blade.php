@extends('layouts.auth')

@section('content')
    <div class="flex flex-row justify-between items-center mb-10">
        <h1 class="text-2xl font-bold">All Task</h1>
        <button onclick="openCreateModal()" class="px-5 py-1 rounded bg-blue-600 text-white">Add Task</button>
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

    <!-- Add Task Modal -->
    <div id="addTaskModal"
        class="fixed inset-0 z-50 bg-black/30 backdrop-blur-sm bg-opacity-10 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md relative">
            <button onclick="closeModal()"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
            <h2 class="text-xl font-bold mb-4 modaltitle">Add New Task</h2>
            <form id="task-form" method="POST" action="{{ route('task-create') }}"
                onsubmit="event.preventDefault();saveForm(event)">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="title">Title</label>
                    <input type="text" id="title" name="title"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="description">Description</label>
                    <textarea id="description" name="description" class="w-full border border-gray-300 rounded px-3 py-2" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="due_date">Due Date</label>
                    <input type="date" id="due_date" name="due_date"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1" for="priority">Priority</label>
                    <select id="priority" name="priority" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
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
                                <button onclick="makeStar(${task.id})" class="px-1 py-1 ${task.is_starred?'text-amber-300':'text-gray-600'} rounded cursor-pointer">
                                    <x-heroicon-s-star class="w-5 h-5" /></button>
                                <button onclick="openEditModal(${task.id})" class="px-1 py-1 text-blue-500 rounded cursor-pointer">
                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                </button>
                                <button onclick="deleteTask(${task.id})"
                                        class="px-1 py-1 text-red-500 rounded cursor-pointer">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                                <button onclick="makeComplete(${task.id})" class="px-1 py-1 bg-green-500 text-white rounded cursor-pointer">
                                    <x-heroicon-o-check class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <h1 class="font-bold">${task.title}</h1>
                        </div>
                        <div>${task.description}</div>
                        
                        <div id="due-date" class="flex items-center mt-auto">
                            ${task.due_date ? `
                            <span class="text-gray-500 border border-gray-400 px-2 py-1 rounded-full shadow-2xl">
                                ${new Date(task.due_date).toLocaleDateString('en-GB')}
                            </span>` : ''}

    <span class="text-gray-500 border 

    ${task.priority == 'low' ? 'bg-green-200 border-green-500' : task.priority == 'medium' ? 'bg-yellow-200 border-yellow-500' : 'bg-red-200 border-red-500'}

    px-2 py-1 rounded-full shadow-2xl uppercase">
    ${task.priority}
    </span>
                    </div>
                        
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

            // document.querySelector("#task-form").addEventListener('submit', saveForm);
        });
    </script>

    <script>
        function openModal() {
            document.getElementById('addTaskModal').classList.remove('hidden');
            document.getElementById('addTaskModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('addTaskModal').classList.remove('flex');
            document.getElementById('addTaskModal').classList.add('hidden');
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeModal();
            }
        });
    </script>

    <script>
        function openCreateModal() {
            document.getElementById('task-form').reset(); // Reset the form
            document.getElementById('task-form').action = "{{ route('task-create') }}"; // Set the action to create
            document.querySelector('.modaltitle').innerText = 'Add New Task'; // Change the title
            openModal(); // Open the modal
        }

        function saveForm(event) {
            event.preventDefault(); // Prevent default form submission

            const form = event.target;
            const formData = new FormData(form);
            const url = form.action;

            // Optional: check what's inside
            console.log('FormData entries:');
            for (const pair of formData.entries()) {
                console.log(`${pair[0]}: ${pair[1]}`);
            }



            fetch(url, {
                    method: 'POST',
                    body: formData,

                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        closeModal();
                        loadTasks();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Something went wrong');
                });
        }


        function deleteTask(id) {
            if (confirm('Are you sure you want to delete this task?')) {
                fetch(`/tasks/delete/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 200) {
                            alert('Task deleted successfully');
                            loadTasks();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => alert('Error: ' + error));
            }
        }

        function openEditModal(id) {
            // Fetch task data and populate the form
            fetch(`/tasks/edit/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        const task = data.data;
                        document.getElementById('title').value = task.title;
                        document.getElementById('description').value = task.description;
                        // Format the date to YYYY-MM-DD
                        if (task.due_date) {
                            const dueDate = new Date(task.due_date);
                            const formattedDate = dueDate.toISOString().split('T')[0];
                            document.getElementById('due_date').value = formattedDate;
                        } else {
                            document.getElementById('due_date').value = '';
                        }

                        const domain = window.location.origin;

                        document.getElementById('priority').value = task.priority;
                        document.getElementById('task-form').action = `${domain}/tasks/update/${task.id}`;
                        document.getElementById('task-form').method = 'POST';
                        document.querySelector('.modaltitle').innerText = 'Edit Task';
                        openModal();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => alert('Error: ' + error));
        }

        function makeStar(id) {

            const domain = window.location.origin;
            const url = `${domain}/tasks/${id}/toggle-starred`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        alert('Task starred successfully');
                        loadTasks();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => alert('Error: ' + error));

        }

        function makeComplete(id) {

            const domain = window.location.origin;
            const url = `${domain}/tasks/${id}/toggle-completed`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        alert('Task Completed successfully');
                        loadTasks();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => alert('Error: ' + error));

        }
    </script>
@endpush
