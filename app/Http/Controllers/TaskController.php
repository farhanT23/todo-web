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
}