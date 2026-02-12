<?php

namespace Modules\Auth\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\DTO\UserRegisterDTO;
use Modules\Auth\Services\AuthService;
use Modules\Users\Models\User;

class AuthController extends Controller
{
    public function registerForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(route('index'));
        }

        return view('auth.register');
    }

    public function register(UserRegisterDTO $userRegisterDTO, AuthService $authService): RedirectResponse
    {
        $authService->create($userRegisterDTO);
        return redirect(route('index'));
    }

    public function loginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(route('index'));
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8'],
            ]
        );

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
        Auth::logout();
        return redirect(route('login.form'));
    }
}
