<?php

declare(strict_types=1);

namespace Modules\Auth\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\DTO\UserRegisterDTO;
use Modules\Auth\Requests\UserLoginRequest;
use Modules\Auth\Services\AuthService;

class AuthController extends Controller
{
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(UserRegisterDTO $userRegisterDTO, AuthService $authService): RedirectResponse
    {
        $authService->registrate($userRegisterDTO);
        return redirect(route('index'));
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(UserLoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials, (bool) $request->input('remember'))) {
            $request->session()->regenerate();
            return redirect(route('index'));
        }

        return back()->withErrors([
            'email' => 'Введён неверный логин или пароль',
        ])->onlyInput('email');
    }

    public function logout(): RedirectResponse
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect(route('login.form'));
    }
}
