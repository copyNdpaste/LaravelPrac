<!doctype html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <h1>projects</h1>
    @foreach ($projects as $project)
        <li>{{ $project->title }}</li>
    @endforeach
</body>
</html>
