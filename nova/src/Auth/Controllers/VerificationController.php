<?php

namespace Nova\Auth\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Nova\Auth\Responses\EmailVerificationResponse;

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

    public function redirectTo()
    {
        return route('home');
    }

    public function show(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            redirect($this->redirectPath());
        }

        return app(EmailVerificationResponse::class);
    }
}
