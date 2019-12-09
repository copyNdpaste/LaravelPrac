@extends('layout')

@section('content')
    <h1 class="title">{{ $project->title }}</h1>
    <div class="content">{{ $project->description }}</div>
    @if ($project->tasks->count())
        <div>
            @foreach ($project->tasks as $task)
                <div>
                    <form method="POST" action="/tasks/{{ $task->id }}">
                        @csrf
                        @method('PATCH')
                        <label class="checkbox {{ $task->completed ? 'is-complete' : '' }}" for="completed">
                            <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                            {{ $task->description }}
                        </label>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
    <p>
        <a href="/projects/{{ $project->id }}/edit">Edit</a>
    </p>

    <form method="POST" action="/tasks" class="box">
        @csrf
        <div class="field">
            <label class="label" for="description">New Task</label>
            <input type="hidden" name="project" value="{{ $project->id }}">
            <input type="text" class="input" name="description" placeholder="">
        </div>
        <button type="submit">Create Task</button>
    </form>
@endsection
