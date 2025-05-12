<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'days',
        'status',
        'project_id',
        'project_task_category_id',
        'order',
    ];

    public function project_task_category(): BelongsTo
    {
        return $this->belongsTo(ProjectTaskCategory::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
