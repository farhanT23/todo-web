<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Mail;
use App\Models\Task;
 
Schedule::call(function () {
    $tomorrow = now()->addDay()->startOfDay();

        // Find tasks due tomorrow with associated users
        $tasks = Task::whereDate('due_date', $tomorrow)
            ->whereNotNull('user_id')
            ->with('user') // Eager load user
            ->get();


        foreach ($tasks as $task) {
            if ($task->user && $task->user->email) {
                Mail::send('emails.reminder',["task"=>$task], function($message) use ($task) {
                    $message->to($task->user->email);
                    $message->subject('You have a task due tomorrow');
                });
            } 
        }
})->daily();