<ul class="nav flex-column">
    <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.index') }}">Главная</a>
    </li>
    <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users') }}">Пользователи</a>
    </li>
</ul>
