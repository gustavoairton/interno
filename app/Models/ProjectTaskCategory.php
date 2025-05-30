<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectTaskCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'project_id',
        'order',
    ];

    public function projectTasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
