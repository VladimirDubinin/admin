<header>
    @if (Auth::check())
        <p>{{ Auth::user()->name }}</p>
        <a href="{{ route('logout') }}">Выйти</a>
    @endif
</header>
