<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test : Une tâche peut être créée
     */
    public function test_task_can_be_created(): void
    {
        $task = Task::create([
            'title' => 'Ma tâche',
            'description' => 'Description',
            'is_completed' => false,
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Ma tâche',
        ]);
        $this->assertFalse($task->is_completed);
    }

    /**
     * Test : Tâche en retard détectée
     */
    public function test_task_is_overdue_when_due_date_is_past(): void
    {
        $task = Task::factory()->overdue()->create();

        $this->assertTrue($task->isOverdue());
    }

    /**
     * Test : Tâche future pas en retard
     */
    public function test_task_is_not_overdue_when_due_date_is_future(): void
    {
        $task = Task::factory()->create([
            'due_date' => now()->addDays(7),
        ]);

        $this->assertFalse($task->isOverdue());
    }

    /**
     * Test : Tâche complétée jamais en retard
     */
    public function test_completed_task_is_never_overdue(): void
    {
        $task = Task::factory()->create([
            'due_date' => now()->subDays(7),
            'is_completed' => true,
        ]);

        $this->assertFalse($task->isOverdue());
    }

    /**
     * Test : Tâche sans date pas en retard
     */
    public function test_task_without_due_date_is_not_overdue(): void
    {
        $task = Task::factory()->create([
            'due_date' => null,
        ]);

        $this->assertFalse($task->isOverdue());
    }

    /**
     * Test : Marquer comme complétée
     */
    public function test_task_can_be_marked_as_completed(): void
    {
        $task = Task::factory()->create([
            'is_completed' => false,
        ]);

        $task->markAsCompleted();

        $this->assertTrue($task->fresh()->is_completed);
    }
}
