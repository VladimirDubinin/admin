<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @vite(['resources/sass/app.scss'])
</head>
<body>
<header>
    @if (Auth::check())
        <p>{{ Auth::user()->name }}</p>
        <a href="{{ route('logout') }}">Выйти</a>
    @endif
</header>
<div id="app">
