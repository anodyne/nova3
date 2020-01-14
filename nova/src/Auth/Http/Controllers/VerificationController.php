<?php

namespace Nova\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Auth\Http\Responses\EmailVerificationResponse;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
