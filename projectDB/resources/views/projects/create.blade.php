@extends('layout')

@section('content')
    <h1>create new projects</h1>
    <form method="POST" action="/projects">
        {{ csrf_field() }}
        <input type="text" name="title" placeholder="Project Title" class="input {{ $errors->has('title') ? 'is-danger' : '' }}" value="{{ old('title') }}">
        <div>
            <textarea name="description" placeholder="Project description" class="textarea {{ $errors->has('description') ? 'is-danger' : '' }}">{{ old('description') }}</textarea>
        </div>
        <div>
            <button type="submit">Create Project</button>
        </div>
    </form>
    @if ($errors->any())
        <div class="notification is-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
