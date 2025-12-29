<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Champs modifiables en masse
     */
    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'due_date',
    ];

    /**
     * Conversion automatique des types
     */
    protected $casts = [
        'is_completed' => 'boolean',
        'due_date' => 'date',
    ];

    /**
     * Vérifie si la tâche est en retard
     */
    public function isOverdue(): bool
    {
        if ($this->is_completed || $this->due_date === null) {
            return false;
        }

        return $this->due_date->isPast();
    }

    /**
     * Marque la tâche comme complétée
     */
    public function markAsCompleted(): void
    {
        $this->update(['is_completed' => true]);
    }
}
