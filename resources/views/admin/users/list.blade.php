@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users') }}
@endsection

@section('content')
    <div class="controls">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Добавить</a>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="filter">
                <h5 class="mb-3">Фильтр</h5>
                <form method="GET" action="{{ route('admin.users') }}">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" class="form-control mb-2" name="name" id="name" value="{{ (!empty($_GET['name'])) ? $_GET['name'] : "" }}">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control mb-2" name="email" id="email" value="{{ (!empty($_GET['email'])) ? $_GET['email'] : "" }}">
                    <div class="d-flex gap-2">
                        <input class="btn btn-sm btn-primary" type="submit" value="Применить">
                        <a  class="btn btn-sm btn-outline-primary" href="{{ route('admin.users') }}">Сбросить</a>
                    </div>
                </form>
            </div>
        </div>
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

    {{ $users->links('parts.breadcrumbs') }}
@endsection
