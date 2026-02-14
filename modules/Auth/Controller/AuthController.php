<?php

declare(strict_types=1);

namespace Modules\Auth\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\DTO\UserRegisterDTO;
use Modules\Auth\Services\AuthService;
use Modules\Users\Models\User;
use Modules\Users\Requests\UserRequest;

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
        $user = $authService->create($userRegisterDTO);
        Auth::login($user);
        return redirect(route('index'));
    }

    public function loginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(route('index'));
        }

        return view('auth.login');
    }

    public function login(UserRequest $request): RedirectResponse
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
        Auth::logout();
        return redirect(route('login.form'));
    }
}
