@extends('layouts.email')

@section('content')
    <h2>Здравствуйте, {{ $name }}</h2>
    <p>Для восстановления пароля на сайте {{ config('app.url') }} перейдите по <a href="{{ $url }}">ссылке</a></p>
@endsection
