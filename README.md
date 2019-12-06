# Basic Routing

php artisan

serve : PHP 개발 서버 상에서 앱을 제공한다

# Layout

layout 파일의 @yield에서 layout을 extends한 파일의 내용을 담을 수 있다.

layout을 extends한 파일에 @extends('layout')으로 layout을 확장한다.

layout의 @yield에서 명시한 부분에 내용을 채우고 싶다면 @section('title')과 @endsection 사이에 title을 작성해준다.

 