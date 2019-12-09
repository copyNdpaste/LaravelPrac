@extends('layout')

@section('content')
    <h1>Edit Project</h1>

    <form method="POST" action="/projects/{{ $project->id }}">
        @csrf
        @method('PATCH')
        <div class="field">
            <label class="label" for="title">Title</label>
            <input type="text"  class="input" name="title" placeholder="Title" value="{{ $project->title }}">
        </div>
        <div class="field">
            <label class="label" for="description">Description</label>
            <textarea name="description" class="textarea">{{ $project->description }}</textarea>
        </div>
        <button type="submit" class="button is-link">Update Project</button>

    </form>
    <form method="POST" action="/projects/{{ $project->id }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="button">Delete Project</button>
    </form>
@endsection
