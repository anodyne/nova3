<?php namespace Nova\Auth\Http\Controllers;

use Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
	use SendsPasswordResetEmails;

	public function __construct()
	{
		parent::__construct();

		$this->middleware('guest');

		$this->views->put('structure', 'auth');
		$this->views->put('template', 'auth');

		$this->isAjax = true;
	}

	public function showLinkRequestForm()
	{
		$this->isAjax = false;

		$this->views->put('page', 'auth.passwords.email');

		$this->pageTitle = _m('auth-reset-password');
	}

	protected function sendResetLinkResponse($response)
	{
		flash()->message(_m('auth-password-link-sent'))->success();

		return back();
	}

	protected function sendResetLinkFailedResponse(Request $request, $response)
	{
		switch ($response) {
			case PasswordBroker::INVALID_USER:
				$message = _m('auth-password-invalid-user');
				break;

			case PasswordBroker::INVALID_PASSWORD:
				$message = _m('auth-password-requirements');
				break;

			case PasswordBroker::INVALID_TOKEN:
				$message = _m('auth-password-invalid-token');
				break;
		}

		return back()->withErrors(['email' => $message]);
	}
}
