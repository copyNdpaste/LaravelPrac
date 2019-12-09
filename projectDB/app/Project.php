<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;

class Project extends Model
{
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);  // (Project) 1:N (Task) 관계
    }

    public function addTask($idArr)
    {
        Task::create([
            'project_id' => $idArr['project'],
            'description' => $idArr['description']
        ]);
    }
}
