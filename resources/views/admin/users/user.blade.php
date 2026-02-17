@extends('layouts.admin')

@section('content')
    <users-component :form-url=" {{ $form_url }}"/>
@endsection
