<?php

declare(strict_types=1);

namespace App\Users\Presentation\Controllers;

use App\Users\Application\Requests\UserLoginRequest;
use App\Users\Domain\DTO\ChangePasswordDTO;
use App\Users\Domain\DTO\RestorePasswordDTO;
use App\Users\Domain\DTO\UserRegisterDTO;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Users\Application\Services\AuthService;
use App\Users\Domain\Models\User;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    public function register(UserRegisterDTO $form): RedirectResponse
    {
        $this->authService->registrate($form);
        return redirect(route('index'));
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

    public function restorePassword(RestorePasswordDTO $form): RedirectResponse
    {
        $user = User::query()->where('email', $form->email)->firstOrFail();
        $this->authService->sendRestorePasswordLink($user);
        Session::flash('status', 'Ссылка для восстановления пароля отправлена на указанный email');
        return redirect()->back();
    }

    public function changePassword(User $user, ChangePasswordDTO $form): RedirectResponse
    {
        $user->password = $form->password;
        $user->save();
        Session::flash('status', 'Пароль успешно изменён');
        return redirect(route('login.form'));
    }
}
