<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {

        $tasks = Task::where('user_id', auth()->id())
        ->when($request->search, function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        })
        ->when($request->completed, function ($query) {
            $query->where('is_completed', 1);
        })
        ->when($request->starred, function ($query) {
            $query->where('is_starred', 1);
        })
        ->when($request->priority, function ($query) use ($request) {
            $query->where('priority', $request->priority);
        })
        ->when($request->from_date, function ($query) use ($request) {
            $query->where('due_date',">=" ,$request->from_date);
        })
        ->when($request->to_date, function ($query) use ($request) {
            $query->where('due_date',"<=" ,$request->to_date);
        })
        ->paginate(6);

        //send as json
        return response()->json([
            'message' => 'Data retrieved successfully',
            "data" => $tasks,
            'status' => 200
        ]);
    }

    public function create(CreateTaskRequest $request)
    {
        $validated = $request->validated();

        $task = Task::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'priority' => $validated['priority'],
            'is_completed' => false,
            'is_starred' => false,
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task,
            'status' => 201
        ]);
    }

    // Get the task to edit
    public function edit($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        return response()->json([
            'message' => 'Task retrieved for editing',
            'data' => $task,
            'status' => 200
        ]);
    }

    // Update the existing task
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validated();

        $task->update($validated);

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task,
            'status' => 200
        ]);
    }

    // Delete the task
    public function delete($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
            'status' => 200
        ]);
    }
}
