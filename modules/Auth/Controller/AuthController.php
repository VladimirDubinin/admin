<?php

namespace Modules\Auth\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(route('admin.index'));
        }

        return view('auth.register');
    }

    public function loginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(route('admin.index'));
        }

        return view('auth.login');
    }
}
