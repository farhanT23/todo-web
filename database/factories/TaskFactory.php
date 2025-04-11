<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enum\TaskPriority;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //get user ids from database
        $userIds = \App\Models\User::pluck('id')->toArray();

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'priority' => $this->faker->randomElement(TaskPriority::getPriorities()), // Assuming TaskPriority is an enum
            'is_completed' => $this->faker->boolean(20), // 20% chance of being completed
            'is_starred' => $this->faker->boolean(10), // 10% chance of being starred
            'user_id' => $userIds[random_int(0,count($userIds)-1)], // Randomly assign a user ID from the database
        ];
    }
}