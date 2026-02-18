@extends('layouts.admin')

@section('content')
    123
    <users-component
        :form_url="'{{ $form_url }}'"
        :back_url="'{{ $back_url }}'"
    ></users-component>
@endsection
