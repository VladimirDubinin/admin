@extends('layouts.admin')

@section('content')
    <div class="controls">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Добавить</a>
    </div>
    <table class="system-table w-100">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Дата регистрации</th>
        </tr>
        </thead>
        <tbody>
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
