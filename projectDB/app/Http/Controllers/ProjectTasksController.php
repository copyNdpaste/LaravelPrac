<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Project;

class ProjectTasksController extends Controller
{
    public function update(Task $task)
    {
        $task->complete(request()->has('completed'));

        return back();
    }

    public function store(Project $project)
    {
        $attributes = request()->validate([
            'project' => ['required'],
            'description' => ['required']
        ]);
        $project->addTask($attributes);

        return back();
    }
}
