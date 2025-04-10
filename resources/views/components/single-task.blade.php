<div class="border border-gray-300 rounded-lg p-4 bg-white shadow-md flex flex-col gap-2">

    <div class="flex justify-between">
        <h1>Task Title </h1>
        <div class="flex gap-2 ">
            <button class="px-1 py-1 text-blue-500  rounded cursor-pointer">
                <x-heroicon-o-pencil-square class="w-5 h-5" />
            </button>
            <button onclick="return confirm('Are you sure to delete?');"
                class="px-1 py-1 text-red-500  rounded cursor-pointer">
                <x-heroicon-o-trash class="w-5 h-5" />
            </button>
            <button class="px-1 py-1 bg-green-500 text-white rounded cursor-pointer">
                <x-heroicon-o-check class="w-5 h-5" />
            </button>
        </div>
    </div>
    <div>Desc</div>
    <div>Due Date</div>
</div>
