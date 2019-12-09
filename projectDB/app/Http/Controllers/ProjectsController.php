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

    public function show(Project $project)  # type hint
    {
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit(Project $project)  # example.com/projects/1/edit
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $project->update(request(['title', 'description']));
        return redirect('/projects');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect('/projects');
    }

    public function store()
    {
        $attribute = request()->validate([
            'title' => ['required', 'min:3'],
            'description' => 'required'
        ]);
        Project::create($attribute);
        return redirect('/projects');
    }
}
