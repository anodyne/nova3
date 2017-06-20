<?php namespace Nova\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Nova\Foundation\Http\Controllers\Controller;

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
		return view('pages.auth.passwords.reset')->with(
			['token' => $token, 'email' => $request->email]
		);
	}

	public function redirectTo()
	{
		return route('home');
	}

	protected function sendResetResponse($response)
	{
		return redirect($this->redirectPath())
			->with('status', _m('auth-password-reset-success'));
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
            'email.required' => _m('auth-validation-email-required'),
            'email.email' => _m('auth-validation-email'),
            'password.required' => _m('auth-validation-password'),
            'password.confirmed' => _m('auth-validation-password-confirm'),
            'password.min' => _m('auth-validation-password-min'),
		];
	}
}
