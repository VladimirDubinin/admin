@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-8 col-lg-6">

                @if (session('status'))
                    <div class="alert alert-success m-0" role="alert">
                        {{ session('status') }}
                    </div>
                @else

                    <div class="d-flex justify-content-between">
                        <a class="btn btn-link" href="{{ route('login') }}">
                            Отмена
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-header">Восстановление пароля</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('password.restore') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Восстановить
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection
