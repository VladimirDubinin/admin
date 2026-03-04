<?php

declare(strict_types=1);

namespace Modules\Auth\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Auth\DTO\ChangePasswordDTO;
use Modules\Auth\DTO\RestorePasswordDTO;
use Modules\Auth\DTO\UserRegisterDTO;
use Modules\Auth\Requests\UserLoginRequest;
use Modules\Auth\Services\AuthService;
use modules\Users\Models\User;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(UserRegisterDTO $form): RedirectResponse
    {
        $this->authService->registrate($form);
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

    public function showRestorePasswordForm(): View
    {
        return view('auth.password_restore');
    }

    public function restorePassword(RestorePasswordDTO $form): RedirectResponse
    {
        $user = User::query()->where('email', $form->email)->firstOrFail();
        $this->authService->sendRestorePasswordLink($user);
        Session::flash('status', 'Ссылка для восстановления пароля отправлена на указанный email');
        return redirect()->back();
    }

    public function showChangePasswordForm(int $id): View
    {
        return view('auth.password_change', ['user_id' => $id]);
    }

    public function changePassword(User $user, ChangePasswordDTO $form): RedirectResponse
    {
        $user->password = $form->password;
        $user->save();
        Session::flash('status', 'Пароль успешно изменён');
        return redirect(route('login.form'));
    }
}
