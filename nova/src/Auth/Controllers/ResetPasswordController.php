<?php

declare(strict_types=1);

namespace Nova\Auth\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Nova\Auth\Responses\ResetPasswordResponse;
use Nova\Foundation\Controllers\Controller;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return app(ResetPasswordResponse::class)->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function redirectTo()
    {
        return route('home');
    }
}
