<?php

/*
    GET /projects (index)
    GET /projects/create (create)
    GET /projects/1 (show)
    POST /projects (store)
    GET /projects/1/edit (edit)
    PATCH /project/1 (update)
    DELETE /projects/1 (destroy)
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('projects', 'ProjectsController');  # route shortcut

Route::post('/tasks', 'ProjectTasksController@store');

Route::post('/completed-tasks/{task}', 'CompletedTasksController@store');
Route::delete('/completed-tasks/{task}', 'CompletedTasksController@destroy');
