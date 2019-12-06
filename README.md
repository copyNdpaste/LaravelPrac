# Basic Routing

php artisan

serve : PHP 개발 서버 상에서 앱을 제공한다

# Layout

layout 파일의 @yield에서 layout을 extends한 파일의 내용을 담을 수 있다.

layout을 extends한 파일에 @extends('layout')으로 layout을 확장한다.

layout의 @yield에서 명시한 부분에 내용을 채우고 싶다면 @section('title')과 @endsection 사이에 title을 작성해준다.

 # Send data to Views

blade 템플릿 상에서의 @foreach는 laravel이 <?php foreach로 바꿔준다.

변수는 {{ }} 내에 써도 된다.

blade 템플릿에서 아래 코드는 같은 의미

```php
<?php echo $foo; ?>
```

```php
<?= $foo; ?>
```

```php
{{ $foo }}
```

{{}}를 사용하면 문자가 escape되기 때문에 안전하다.

입력받은 문자 그대로 활용 싶으면(ex: html tag 사용 등)

```php
{!! $foo !!}
```

템플릿에 data를 보내는 방법

```php
return view('welcome', [
  'tasks'=>$tasks,
  'foo'=>'foo~'
]);
```

```php
return view('welcome')->with([
  'tasks'=>$tasks,
  'foo'=>'foo~'
]);
```

```php
return view('welcome')->withTasks($tasks)->withFoo('foo~');
```

```php
return view('welcome', [
  'tasks' => $tasks,
  'foo' => 'foobar',
  'title' => request('title')
]);
```

# Controllers

```bash
php artisan make:controller PagesController
```

php artisan을 통해 PagesController라는 controller를 생성한다.

기존에 있던 route를 지우고 다음과 같이 작성한다.

```php
Route::get('/', 'PageController@home');
Route::get('/about', 'PageController@about');
Route::get('/contact', 'PageController@contact');
```

PagesController에서 route 이름에 맞게 view를 랜딩해준다.

```php
<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function home()
    {
        return view('welcome', [
            'foo' => 'bar'
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
```

