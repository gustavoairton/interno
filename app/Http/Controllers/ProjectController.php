<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function show($id)
    {
        $project = Project::find($id)->load(['project_tasks', 'project_task_categories']);
        if ($project) {
            return response()->json(['project' => $project]);
        } else {
            return response()->json(['message' => 'Project not found'], 404);
        }
    }
}
