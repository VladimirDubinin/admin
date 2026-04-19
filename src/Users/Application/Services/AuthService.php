<?php

declare(strict_types=1);

namespace App\Users\Application\Services;

use App\Users\Domain\Models\User;
use App\Users\Infrastructure\Mail\ForgotPasswordSend;
use App\Users\Infrastructure\Repositories\UserRepository;
use Carbon\Carbon;
use App\Users\Domain\DTO\UserRegisterDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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
