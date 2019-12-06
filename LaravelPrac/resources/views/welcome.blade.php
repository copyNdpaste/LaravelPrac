@extends('layout')  <!--layout.blade.php 템플릿 사용-->

@section('content')  <!--작성하고자 하는 내용을 쓰고 layout.blade.php의 content에 갖다 붙인다.-->
    <h1>{{ $foo }}</h1>
@endsection
