<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();  # root 디렉토리에서 시작한다고 명시하지 않으면 namespace 때문에 App\Http\Controllers\App\Project가 돼버린다.

        return view('projects.index', compact('projects'));  # projects 디렉토리의 index 파일을 랜딩한다.
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit($id)  # example.com/projects/1/edit
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    public function update($id)
    {
        $project = Project::findOrFail($id);
        $project->title = request('title');
        $project->description = request('description');
        $project->save();
        return redirect('/projects');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect('/projects');
    }

    public function store()
    {
        $project = new Project();
        $project->title = request('title');
        $project->description = request('description');
        $project->save();
        return redirect('/projects');
    }
}
