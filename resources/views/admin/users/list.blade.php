@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users') }}
@endsection

@section('content')
    <div class="controls">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Добавить</a>
    </div>
    <table class="table table-parts table-sm table-bordered table-hover">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Дата регистрации</th>
        </tr>
        </thead>
        <tbody class="parts table-group-divider">
        @foreach($users as $user)
            <tr>
                <td><a href="{{ route('admin.users.edit', $user->id) }}">{{ $user->id }}</a></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles()->pluck('display_name')->implode(', ') }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
