<?php

declare(strict_types=1);

namespace Src\Auth\Services;

use App\Mail\ForgotPasswordSend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Src\Auth\DTO\UserRegisterDTO;
use Src\Users\Models\User;
use Src\Users\Repositories\UserRepository;

readonly class AuthService
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function registrate(UserRegisterDTO $userRegisterDTO): User
    {
        $user = $this->userRepository->create([
            'name' => $userRegisterDTO->name,
            'email' => $userRegisterDTO->email,
            'password' => $userRegisterDTO->password,
        ]);
        $user->addRole('user');

        Auth::login($user);
        return $user;
    }

    public function sendRestorePasswordLink(User $user): void
    {
        $changePasswordUrl = URL::temporarySignedRoute(
            'password.change.form',
            Carbon::now()->addHours(1),
            ['user' => $user->id]
        );

        Mail::to($user->email)->send(new ForgotPasswordSend($user->name, $changePasswordUrl));
    }
}
