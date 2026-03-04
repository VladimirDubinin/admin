<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use App\Mail\ForgotPasswordSend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Modules\Auth\DTO\UserRegisterDTO;
use modules\Users\Models\User;

class AuthService
{
    public function registrate(UserRegisterDTO $userRegisterDTO): User
    {
        $user = new User();
        $user->name = $userRegisterDTO->name;
        $user->email = $userRegisterDTO->email;
        $user->password = $userRegisterDTO->password;
        $user->save();
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
