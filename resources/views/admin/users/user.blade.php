@extends('layouts.admin')

@section('content')
    <users-component
        :form_url="'{{ $form_url }}'"
        :back_url="'{{ $back_url }}'"
    ></users-component>
@endsection
