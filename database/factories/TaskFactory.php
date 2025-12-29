<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'is_completed' => false,
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
        ];
    }

    /**
     * Tâche complétée
     */
    public function completed(): static
    {
        return $this->state([
            'is_completed' => true,
        ]);
    }

    /**
     * Tâche en retard
     */
    public function overdue(): static
    {
        return $this->state([
            'due_date' => fake()->dateTimeBetween('-1 month', '-1 day'),
            'is_completed' => false,
        ]);
    }
}
