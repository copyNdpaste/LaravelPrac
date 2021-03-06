# Databases and Migrations

.env에는 설정 및 개인 정보가 있다

DB 관리 툴을 설치하고 username, password 등을 지정한다.

<img width="897" alt="image-20191208124105009" src="https://user-images.githubusercontent.com/18900976/70387368-e2b6ec00-19e7-11ea-9451-14486a216803.png">

.env 파일에서도 설정을 해준다.

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tutorial
DB_USERNAME=root
DB_PASSWORD=
```

Config 디렉토리의 database.php에는 default 설정이 'DB_CONNECTION'인데 .env에서 지정되어 있지 않은 경우엔 2번째 인자인 'mysql'이 된다.

```bash
'default' => env('DB_CONNECTION', 'mysql'),
```

database.php에서 밑으로 내려가보면 DBMS마다 설정이 각각 있다. 여기서도 .env에서 지정한 것 아니면 값이 지정되지 않은 경우 임의로 설정한 값을 사용할 수 있다.

비번 관련 오류

https://stackoverflow.com/questions/55237257/mysql-validate-password-policy-unknown-system-variable

mysql 삭제 설치 방법 [https://velog.io/@max9106/mac%EC%97%90-MySQL-%EC%84%A4%EC%B9%98%ED%95%98%EA%B8%B0-4ck17gzjk3](https://velog.io/@max9106/mac에-MySQL-설치하기-4ck17gzjk3)

caching_sha_password로 비번 설정했다가 DB 툴 상에서 접속이 불가능 해 질 경우 다시 이전 방식으로 비번 설정을 한다.

```
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'your_password_here'; 
```

마이그레이트를 해서 migration에 작성된 스키마를 테이블로 만든다.

```bash
php artiasn migrate
```

만들어진 테이블을 rollback하고 싶다면 다음 명령을 입력한다.

```bash
php artisan migrate:rollback
```

테이블 column명을 바꾸고 싶은 경우 database > migrations > users_table.php로 들어간다.

```php
$table->string('name');
```

```php
$table->string('username');
```

테이블 구조를 바꾸고 싶은 경우 이렇게 migrations 파일에서 schema를 변경한 뒤 명령어 창에서

```bash
php artisan migrate:rollback
php artisan migrate
```

를 하거나

```bash
php artisan migrate:fresh
```

를 해준다.

fresh는 모든 테이블을 drop 하고 새롭게 테이블을 생성한다.

artisan 명령어를 확인하고 싶다면 다음을 입력한다.

```bash
php artisan
```

새 파일과 클래스를 생성하고 싶다면

```bash
php artisan make:*
```

새로운 마이그레이션 생성하기

```bash
php artisan make:migration
```

migrate를 할 때 up() 메서드가 실행되고 rollback할 때는 down() 메서드가 실행된다. down()에 있는 

```php
Schema::dropIfExists('projects');
```

를 주석처리 하고

```bash
php artisan migrate:rollback
```

을 하면 테이블이 그대로 남아 있게 된다.

```bash
php artisan migrate:fresh
```

를 하면 down() 메서드와 상관 없이 모든 테이블을 drop하고 모든 마이그레이션을 실행한다.

# Eloquent, Namespacing, and MVC

```bash
php artisan migrate
```

를 하면 라라벨은 모든 마이그레이트 되지 않은 마이그레이션을 실행(up)한다.

Eloquent는 라라벨의 실행 중인 레코드다.

```bash
php artisan make:model Project
```

model은 app 디렉토리에서 찾을 수 있다.

```bash
php artisan tinker
```

로 터미널 상에서 php를 사용하거나 laravel 프로젝트에 접근할 수 있다. 

app 디렉토리에 있는 Project 모델 객체를 만들어 crud를 할 수도 있다.

```bash
$project = App\Project;
$project->title = 'My First Project';
$project->description = 'Lorem ipsum';
$proejct->save();
```

read

```php
App\Project::latest()->first();  # 최신 레코드
App\Project::first()->title;  # 첫번째 레코드의 title
App\Project::all();  # 테이블의 모든 레코드
App\Project::all()[0]; # 첫번째 레코드
App\Project::all()->map->title;  # 모든 레코드의 title
App\Project::all()->map->title[0]; # 모든 레코드 중 첫번째 title
```

model에 접근해서 메서드를 사용한다.

컨트롤러를 생성한다.

```bash
php artisan make:controller ProjectsController
```

web.php에 라우터를 작성한다.

```php
Route::get('/projects', 'ProjectsController@index');  # /project에 요청이 들어오면 ProjectsController의 index 메서드가 실행됨.
```

ProjectsController.php에 다음 index 메서드를 작성한다.

```php
class ProjectsController extends Controller
{
    public function index()
    {
        return view('projects.index');  # projects 디렉토리의 index 파일을 랜딩한다.
    }
}
```

index.blade.php는 resources > views > projects에 작성한다.

index.blade.php에 html을 작성하고 서버를 실행한다.

```bash
php artisan serve
```

127.0.0.1:8000/projects에 접속해서 페이지가 잘 뜨는지 확인한다.

routes는 요청된 URI에 반응하고 controller를 로딩한다. controller는 view를 리턴한다. view는 유저에게 제공된다.

PSR-4

namespace를 활용해서 이름 충돌이 나지 않게 현재 파일이 속한 디렉토리 경로를 명시해준다.

controller가 model에서 data를 가져와서 가공, 처리하기 위해 다음을 작성한다.

```php
public function index()
{
    $projects = \App\Project::all();  # root 디렉토리에서 시작한다고 명시하지 않으면 namespace 때문에 App\Http\Controllers\App\Project가 돼버린다.

    return $projects;  # json 형식
}
```

브라우저 상에서 잘 정돈된 json 형태를 보고 싶다면 chrome 확장 프로그램인 json formatter를 설치한다.

json 형식의 값을 view에 보낸다.

```php
public function index()
    {
        $projects = \App\Project::all();  # root 디렉토리에서 시작한다고 명시하지 않으면 namespace 때문에 App\Http\Controllers\App\Project가 돼버린다.

        return view('projects.index', compact('projects'));  # projects 디렉토리의 index 파일을 랜딩한다.
    }
```

Index.blade.php에선 json 데이터를 출력해준다.

```php+HTML
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
```

`라라벨의 기본 구조`

>routes는 요청된 URI에 맞는 controller를 호출한다.
>
>controller는 데이터베이스에 query를 보내 CRUD를 하고, data를 view에 전달한다.
>
>view는 전달 받은 data를 출력한다.

# Directory Structure Review

__Files__

`.editorconfig`

> editor에게 어떤 format을 원하는 지 알려준다.

`.env`

> Local 또는 product 환경을 설정할 수 있다.
>
> DB나 PUSHER, Redis, Mail 설정을 할 수 있다.

`artisan`

> 터미널에서 php artisan 명령을 칠 경우 artisan 파일이 실행된다.

`composer.json`

> 의존성 설정

`composer.lock`

> project를 공유하는 사용자가 의존성 설정을 일치시키기 위한 파일

`package.json`

> 프론트엔드 설정

`webpack.mix.js`

> 라라벨 앱에서 assets을 컴파일하고 최적화하기 위한 도구

__Directories__

`vendor`

> composer dependency가 설치되는 디렉토리.

`tests`

> testcase를 작성하는 디렉토리

`storage`

> log, cache, session, 컴파일된 view 등 저장

`routes`

> web.php에선 route를 정할 수 있다.
>
> console.php에선 artisan 명령어를 추가할 수 있다.

`resources`

> js, sass, view 등이 webpack.mix.js에 의해 컴파일되면 resources 디렉토리에 저장된다.

`public`

> js, css

`databaase`

> migrations: table schema 지정
>
> factories:  지정된 조건에 맞는 table의 test data 생성. 자동
>
> seeds: test data 생성. 수동

`config`

> 앱, 인증, 캐시, 데이터베이스 등 다양한 환경 설정

`bootstrap`

> 라라벨 프로젝트가 실행될 때 쓰임, UI를 위한 css library와 관계 없음

`app`

> 모델, 컨트롤러, 복잡한 artisan 명령어
>
> 서버로 들어오는 모든 요청에 대해 Kernel.php의 middleware를 확인한다.
>
> service providers는 라라벨에서 중요한 개념이다. 라라벨의 모든 코어 서비스는 서비스 프로바이더를 통해 부트스트래핑(이벤트 리스너, 미들웨어, 라우트 등록)된다.

# Form Handling and CSRF Protection

web.php에 create 페이지로 이동하는 route와 글을 생성하는 post route 추가

```php
Route::post('/projects', 'ProjectsController@store');
Route::get('/projects/create', 'ProjectsController@create');
```

ProjectsController.php에 메서드 추가

```php
public function create()
{
  return view('projects.create');
}

public function store()
{
  return request()->all();
}
```

create.blade.php에 html 추가

```php+HTML
<form method="POST" action="/projects">
  <input type="text" name="title" placeholder="Project Title">
  <div>
    <textarea name="description" placeholder="Project description"></textarea>
  </div>
  <div>
    <button type="submit">Create Project</button>
  </div>
</form>
```

Form 태그의 post 메서드를 사용할 때 csrf 토큰이 없으면 419 에러가 난다. csrf_field()를 추가해준다.

```php+HTML
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
```

요청으로 온 특정 값에 접근하고 싶을 때는 request('name')

form에서 요청이 온 것을 저장하려면

```php
public function store()
    {
        $project = new Project();
        $project->title = request('title');
        $project->description = request('description');
        $project->save();
        return redirect('/projects');
    }
```

##### csrf token

> kernel.php의 middlewaregroup의 VerifyCsrfToken이 csrf token이 유효한지 확인할 때 사용된다.

서버에 위변조된 데이터가 오지 못하도록 인증된 token을 갖고 있는 경우에만 서버와 소통할 수 있다.

# Routing Conventions Worth Following

REST : Representational State Transfer

web.php에 다음과 같이 routes를 작성한다.

```php
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

Route::get('/projects', 'ProjectsController@index');  # /project에 요청이 들어오면 ProjectsController의 index 메서드가 실행됨.
Route::get('/projects/create', 'ProjectsController@create');
Route::get('/projects/{project}', 'ProjectsController@show');
Route::post('/projects', 'ProjectsController@store');
Route::get('/projects/{project}/edit', 'ProjectsController@edit');
Route::patch('/projects/{project}', 'ProjectsController@update');
Route::delete('/projects/{project}', 'ProjectsController@destroy');

```

artisan을 활용해 등록된 route list를 확인할 수 있다.

```bash
php artisan route:list
```

controller 생성 시 필요한 함수를 만들어 주는 명령어.

```bash
php artisan make:controller PostsController -r
```

다음 명령어를 입력하면 Post 모델이 없는 경우 생성하겠냐고 물어본다. yes를 입력하면 controller와 model이 생성되고 controller 안에는 model이 import 된다.

```bash
php artisan make:controller PostsController -r -m Post
```

타입 힌팅을 이용해서 데이터베이스에 있는 모델 전체에 접근할 수 있다. 모델을 직접 쓰고 query문을 작성하지 않아도 된다.

# Faking PATCH and DELETE Requests

Views 디렉토리에 layout.blade.php를 생성한다

```php+HTML
<!doctype html>
<html lang="en">
<head>
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css">
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>

```

projects 디렉토리에 edit.blade.php를 생성한다.

```php+HTML
@extends('layout')

@section('content')
    <h1>Edit Project</h1>
    {{ $project }}
@endsection

```

Http > Controllers 디렉토리의 ProjectsController.php에 edit 메서드를 작성한다.

```php
public function edit($id)  # example.com/projects/1/edit
    {
        return $id;
        $project = Project::find($id);
        return view('projects.edit', compact('project'));
    }
```

Edit.blade.php

```php+HTML
@extends('layout')

@section('content')
    <h1>Edit Project</h1>

    <form method="POST" action="/projects/{{ $project->id }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
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
@endsection

```

PATCH method는 없기 때문에 method를 POST로 작성하고 실제로 뭘 의미하는지 알려주기 위한 method_field('PATCH')를 이용한다. 이 메서드는 hidden input을 생성한다.

```html
<input type="hidden" name="_method" value="PATCH">
```

ProjectsController.php

```php
public function update($id)
{
  $project = Project::find($id);
  $project->title = request('title');
  $project->description = request('description');
  $project->save();
  return redirect('/projects');
}
```

# Form Delete Requests

edit.blade.php에 delete를 위한 form을 추가한다

```php+HTML
<form method="POST" action="/projects/{{ $project->id }}">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
  <button type="submit" class="button">Delete Project</button>
</form>
```

method_field에 'DELETE'를 적어줬기 때문에 action에 적한 URI를 따라가면 destroy 메서드가 실행된다.

```php
public function destroy($id)
{
  $project = Project::find($id);
  $project->delete();
  return redirect('/projects');
}
```

```php
{{ method_field('DELETE') }}
{{ csrf_field() }}
```

위, 아래 코드는 같은 의미.

```php
@method('DELETE')
@csrf
```

존재하지 않는 id에 접근하는 경우 404 에러 페이지 처리

```php
find() 대신 findOrFail()
```

# Cleaner Controllers and Mass Assignment Concerns

index에서 title을 클릭할 수 있게 한다.

```html
<!doctype html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <h1>projects</h1>
    @foreach ($projects as $project)
        <li>
            <a href="/projects/{{ $project->id }}">
                {{ $project->title }}
            </a>
        </li>
    @endforeach
</body>
</html>
```

Show 메서드

```php
public function show($id)
{
  $project = Project::findOrFail($id);
  return view('projects.show', compact('project'));
}
```

type hint 적용

```php
public function show(Project $project)  # type hint
{
    return view('projects.show', compact('project'));
}
```

데이터 저장 시 store 메서드에서 create 메서드 활용

```php
public function store()
{
  Project::create([
    'title' => request('title'),  // "add title to fillable property to allow mass assignment on App\Project" in Project Model
    'description' => request('description')
  ]);
  return redirect('/projects');
}
```

그냥 사용하면 mass assignment 이슈로 인해 에러가 남. Project.php의 Project 클래스의 fillable 변수에 request에서 값을 받아 저장할 

> mass assignment vulnerability는 request를 통해 예상치 못한 HTTP 인자가 전달되는 것이다. 원치 않게 DB column을 변경해버릴 수 있다. mass assign을 하고 싶은 모델에 $fillable 속성을 사용해야 한다. [출처](https://laravel.com/docs/5.7/eloquent#mass-assignment) 데이터를 서버에 전송하게 될 때 원치 않는 값까지 전달되는 것을 방지한다.

```php
class Project extends Model
{
    protected $fillable = [
        'title', 'description',
    ];
}
```

$fillable(white list)과 반대되는 건 $guarded(black list)이다. 아래와 같이 작성하면 모든 인자를 허용하는 것이다.

```php
$guarded = [];
```

Store 메서드를 더욱 간단하게.

```php
public function store()
{
  Project::create(request(['title', 'description']));
  return redirect('/projects');
}
```

# Two Layers of Validation

frontend와 backend 모두에서 유효성 검사를 해야 한다.

controller의 store 메서드에서 유효성 검사를 한다. 유효성 검사를 해서 실패하면 이전 페이지로 redirect 된다. Min:3은 최소 글자 수

```php
public function store()
{
  request()->validate([
    'title' => ['required', min:3, max:255],
    'description' => 'required'
  ]);
  Project::create(request(['title', 'description']));
  return redirect('/projects');
}
```

유효성 검사 실패했을 때 redirect되면서 지금까지 작성한 글이 초기화된다. 이를 방지하려면 value="{{ old('title') }}"을 넣어준다.

[validation rules](https://laravel.com/docs/5.8/validation#available-validation-rules)

# Your First Eloquent Relationships

Project 모델과 join하기 위한 Task 모델과 factory를 만든다.

```bash
php artisan make:model Task -m -f
```

Task.php에서 migration을 수정한다.

```php
public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedInteger('project_id');
      $table->string('description');
      $table->boolean('completed')->default(false);
      $table->timestamps();
    });
}
```

migrate한다.

```bash
php artisan migrate
```

Project.php에서 Task를 참조한다.

```php
public function tasks()
{
  return $this->hasMany(Task::class);
}
```

```bash
php artisan tinker
App\Project::first()->tasks;  // 첫번째 project와 관계 있는 task 출력
App\Task::first()->project;  // 첫번째 task와 관계있는 project 출력
```

[relationship 문서](https://laravel.kr/docs/5.1/eloquent-relationships)

* 1:1

> $this->hasOne()
>
> $this->belongsTo()

* 1:N

> $this->hasMany()  // 1쪽
>
> $this->belongsTo()  // N쪽

* N:M

> $this->belongsToMany()

# Create New Project Tasks

show.blade.php

```php+HTML
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

```

web.php

```php
Route::patch('/tasks/{task}', 'ProjectTasksController@update');
Route::post('/tasks', 'ProjectTasksController@store');
```

ProjectTasksController.php

```php
class ProjectTasksController extends Controller
{
    public function update(Task $task)
    {
        $task->update([
           'completed' => request()->has('completed')
        ]);
        return back();
    }

    public function store(Project $project)
    {
        $attributes = request()->validate([
            'project' => ['required'],
            'description' => ['required']
        ]);
        $project->addTask($attributes);

        return back();
    }
}
```

layout.blade.php

```php+HTML
<style>
  .is-complete {
    text-decoration: line-through;
  }
</style>
```

Project.php

```php
public function addTask($idArr)
{
  Task::create([
    'project_id' => $idArr['project'],
    'description' => $idArr['description']
  ]);
}
```

Task.php

```php
class Task extends Model
{
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
```

# Better Encapsulation

Task update는 ProjectTasksController.php에서 요청하되 실제 처리는 Task.php에서 한다. ProjectTasksControllers는 Task 모델의 complete라는 메서드에 인수만 넣어주면 된다. complete()의 내부 내용을 알 필요가 없다.

ProjectTasksController.php

```php
public function update(Task $task)
{
  $task->complete(request()->has('completed'));

  return back();
}
```

Task.php에선 complete 메서드를 정의하는데, task가 완료, 미완료를 인자로 판단하고 그에 맞게 현재 task에 대한 complete column을 update한다.

Task.php

```php
public function complete($completed = true)
{
  $this->update(['completed' => $completed]);
}
```

[Request에 어떤 값이 존재하는 지 확인하는 has()]([https://laravel.kr/docs/5.7/requests#%EC%9E%85%EB%A0%A5%EA%B0%92%EC%9D%B4%20%EC%A1%B4%EC%9E%AC%ED%95%98%EB%8A%94%EC%A7%80%20%ED%99%95%EC%9D%B8%ED%95%98%EA%B8%B0](https://laravel.kr/docs/5.7/requests#입력값이 존재하는지 확인하기))

encapsulation을 한 덕에 controller는 가독성이 좋아지고 eloquent model은 동작을 더 갖게 되었다. 클래스에선 어떤 일을 할 수 있는지 없는지 쉽게 알 수 있다.

Task Eloquent에서 complete, incomplete 나누기

Task.php

```php
public function complete($completed = true)
{
  $this->update(['completed' => $completed]);
}

public function incomplete()
{
  $this->complete(false);
}
```

ProjectTasksController.php

```php
public function update(Task $task)
{
  $isComplete = request()->has('completed');

  //        if($isComplete){
  //            $task->complete();
  //        }else{
  //            $task->incomplete();
  //        }

  $isComplete ? $task->complete() : $task->incomplete();

  // $isComplete = request()->has('completed') ? 'complete' : 'incomplete';
  // $isComplete(); // 동적 메소드
  return back();
}
```

# When in Doubt

ProjectTasksController.php에 작성했던 task->complete() 호출하는 부분을 controller로 분리시킨다.

controller 생성

```bash
php artisan make:controller CompletedTasksController
```

show.blade.php에서 form 변경

```php+HTML
<form method="POST" action="/completed-tasks/{{ $task->id }}">
  @csrf
  @if ($task->completed) @method('DELETE')
  @endif
  <label class="checkbox {{ $task->completed ? 'is-complete' : '' }}" for="completed">
    <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
    {{ $task->description }}
  </label>
</form>
```

web.php

```php
// Route::patch('/tasks/{task}', 'ProjectTasksController@update');
Route::post('/completed-tasks/{task}', 'CompletedTasksController@store');
Route::delete('/completed-tasks/{task}', 'CompletedTasksController@destroy');
```

CompletedTasksController

```php
class CompletedTasksController extends Controller
{
    public function store(Task $task){
        $task->complete();

        return back();
    }

    public function destroy(Task $task)
    {
        $task->incomplete();

        return back();
    }
}
```

