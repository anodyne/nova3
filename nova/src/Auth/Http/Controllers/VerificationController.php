<?php

namespace Nova\Auth\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Auth\Http\Responses\VerifyEmailResponse;

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

	public function show(Request $request)
	{
		if ($request->user()->hasVerifiedEmail()) {
			redirect($this->redirectPath());
		}

		return app(VerifyEmailResponse::class);
	}

	public function redirectTo()
	{
		return route('home');
	}
}
