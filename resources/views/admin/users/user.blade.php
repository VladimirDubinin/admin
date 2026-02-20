@extends('layouts.admin')

@section('content')
    <users-component
        :form_url="'{{ $form_url }}'"
        :store_url="'{{ $store_url }}'"
        :back_url="'{{ $back_url }}'"
        :delete_url="'{{ $delete_url ?? null }}'"
    ></users-component>
@endsection
