<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = \App\Project::all();  # root 디렉토리에서 시작한다고 명시하지 않으면 namespace 때문에 App\Http\Controllers\App\Project가 돼버린다.

        return view('projects.index', compact('projects'));  # projects 디렉토리의 index 파일을 랜딩한다.
    }
}
