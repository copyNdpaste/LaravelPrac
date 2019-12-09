<?php

Route::get('/', function () {
    return view('welcome');
});

/*
    GET /projects (index)
    GET /projects/create (create)
    GET /projects/1 (show)
    POST /projects (store)
    GET /projects/1/edit (edit)
    PATCH /project/1 (update)
    DELETE /projects/1 (destroy)
*/

Route::resource('projects', 'ProjectsController');  # route shortcut
//Route::get('/projects', 'ProjectsController@index');  # project에 요청이 들어오면 ProjectsController의 index 메서드가 실행됨.
//Route::get('/projects/create', 'ProjectsController@create');
//Route::get('/projects/{project}', 'ProjectsController@show');
//Route::post('/projects', 'ProjectsController@store');
//Route::get('/projects/{project}/edit', 'ProjectsController@edit');
//Route::patch('/projects/{project}', 'ProjectsController@update');
//Route::delete('/projects/{project}', 'ProjectsController@destroy');
