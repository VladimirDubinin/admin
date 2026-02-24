<ul class="nav flex-column">
    <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <span class="icon">
                <i class="fas fa-th-list"></i>
            </span>
            Главная
        </a>
    </li>
    <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users') }}">
            <span class="icon">
                <i class="fas fa-solid fa-th-list"></i>
            </span>
            Пользователи
        </a>
    </li>
</ul>
