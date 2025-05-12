<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sale_id',
        'business_name',
        'logo_url'
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function project_tasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class);
    }

    public function project_task_categories(): HasMany
    {
        return $this->hasMany(ProjectTaskCategory::class);
    }
}
