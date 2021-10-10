<?php

declare(strict_types=1);

namespace Nova\Auth\Controllers;

use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Nova\Auth\Responses\EmailVerificationResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function redirectTo(): string
    {
        return route('home');
    }

    public function show(Request $request): Responsable
    {
        if ($request->user()->hasVerifiedEmail()) {
            redirect($this->redirectPath());
        }

        return app(EmailVerificationResponse::class);
    }
}
