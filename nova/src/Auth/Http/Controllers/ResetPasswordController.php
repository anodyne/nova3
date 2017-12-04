<?php namespace Nova\Auth\Http\Controllers;

use Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
	use ResetsPasswords;

	public function __construct()
	{
		parent::__construct();

		$this->middleware('guest');

		$this->views->put('structure', 'auth');
		$this->views->put('template', 'auth');

		$this->isAjax = true;
	}

	public function showResetForm(Request $request, $token = null)
	{
		$this->isAjax = false;

		$this->views->put('page', 'auth.passwords.reset');

		$this->pageTitle = _m('auth-reset-password');

		$this->data->token = $token;
		$this->data->email = $request->email;
	}

	public function redirectTo()
	{
		return route('home');
	}

	protected function sendResetResponse($response)
	{
		flash()->message(_m('auth-password-reset-success'))->success();

		return redirect($this->redirectPath());
	}

	protected function sendResetFailedResponse(Request $request, $response)
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

		return back()
			->withInput($request->only('email'))
			->withErrors(['email' => $message]);
	}

	protected function validationErrorMessages()
	{
		return [
			'token.required' => _m('auth-validation-token'),
			'email.required' => _m('validation-email-required'),
			'email.email' => _m('validation-email-valid'),
			'password.required' => _m('validation-password-required'),
			'password.confirmed' => _m('validation-password-confirm'),
			'password.min' => _m('validation-password-min'),
		];
	}
}
