@include('parts.head')

<div class="admin-wrapper">
    <div class="container-fluid p-0">
        <div class="sidebar">
            <div class="logo">
                <a href="{{ route('admin.index') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }}">
                </a>
            </div>
            <div class="login">
                @if (Auth::check())
                    <div class="name">{{ Auth::user()->name }}</div>
                    <a href="{{ route('logout') }}">Выйти</a>
                @endif
            </div>
            <div class="menu">
                @include('parts.leftmenu')
            </div>
        </div>
        <main class="content">
            <div class="content-wrapper">
                <div class="breadcrumbs">
                    @yield('breadcrumbs')
                </div>
                <h2 class="mb-3">{{ $pageTitle ?? 'Панель администрирования'}}</h2>
                @yield('content')
            </div>
        </main>
    </div>
</div>

@include('parts.footer')
