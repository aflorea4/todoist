<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition()
    {
        static $user_id, $title, $description, $completed, $due_date;
        return [
            'user_id' => $user_id ?: User::all()->random()->id,
            'title' => $title ?: $this->faker->catchPhrase,
            'description' => $description ?: $this->faker->paragraph(2),
            'completed' => $completed ?: rand(0, 1),
            'due_date' => $due_date ?: Carbon::now()
        ];
    }
}
