<!doctype html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <h1>create new projects</h1>
    <form method="POST" action="/projects">
        {{ csrf_field() }}
        <input type="text" name="title" placeholder="Project Title">
        <div>
            <textarea name="description" placeholder="Project description"></textarea>
        </div>
        <div>
            <button type="submit">Create Project</button>
        </div>
    </form>
</body>
</html>
