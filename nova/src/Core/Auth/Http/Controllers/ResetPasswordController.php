<?php namespace Nova\Core\Auth\Http\Controllers;

use Date;
use BaseController;
use Illuminate\Http\Request;
use Nova\Core\Auth\Events;
use Nova\Core\Auth\Notifications;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends BaseController
{
	use ResetsPasswords;

	public function __construct()
	{
		parent::__construct();

		$this->views->put('structure', 'auth');
		$this->views->put('template', 'auth');

		$this->middleware('guest');
	}

	public function showResetForm(Request $request, $token = null)
	{
		$this->views->put('page', 'auth/reset');

		$this->data->email = $request->email;
		$this->data->token = $token;
	}

	protected function sendResetResponse($response)
	{
		$request = request();

		// Fire the password reset event
		event(new Events\PasswordReset($request->get('email'), Date::now()));

		// Create a new notification for the user
		$request->user()->notify(new Notifications\PasswordReset);

		flash()->success(_m('success-exclamation'), _m('auth-password-reset-success'));
		
		return redirect()->route('home');
	}

	protected function sendResetFailedResponse(Request $request, $response)
	{
		switch ($response) {
			case PasswordBroker::INVALID_USER:
				event(new Events\PasswordResetFailed($request->get('email'), $response));

				flash()->error(_m('error-exclamation'), _m('auth-password-invalid-user'));
				
				return back();
				break;

			case PasswordBroker::INVALID_PASSWORD:
				event(new Events\PasswordResetFailed($request->get('email'), $response, Date::now()));

				flash()->error(_m('error-exclamation'), _m('auth-password-requirements'));
				
				return back()->withInput($request->only('email'));
				break;

			case PasswordBroker::INVALID_TOKEN:
				event(new Events\PasswordResetFailed($request->get('email'), $response, Date::now()));

				flash()->error(_m('error-exclamation'), _m('auth-password-invalid-token'));
				
				return back();
				break;
		}
	}
}
