<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Project;

class ProjectTasksController extends Controller
{
    public function update(Task $task)
    {
        $isComplete = request()->has('completed');

//        if($isComplete){
//            $task->complete();
//        }else{
//            $task->incomplete();
//        }

        $isComplete ? $task->complete() : $task->incomplete();

        // $isComplete = request()->has('completed') ? 'complete' : 'incomplete';
        // $isComplete(); // 동적 메소드
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
