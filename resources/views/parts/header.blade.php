<header>
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-6 col-sm-10"></div>
            <div class="login col-6 col-sm-2">
                @if (Auth::check())
                    <span>{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}">Выйти</a>
                @else
                    <a href="{{ route('login') }}">Войти</a>
                @endif
            </div>
        </div>
    </div>
</header>
