<?php namespace Nova\Core\Auth\Http\Controllers;

use Date, BaseController;
use Nova\Core\Auth\Events;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends BaseController {
	
	use SendsPasswordResetEmails;

	public function __construct()
	{
		parent::__construct();

		$this->views->put('structure', 'auth');
		$this->views->put('template', 'auth');

		$this->middleware('guest');
	}

	public function showLinkRequestForm()
	{
		$this->views->put('page', 'auth/password');
	}

	public function sendResetLinkEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email']);

		$response = $this->broker()->sendResetLink(
			$request->only('email'), $this->resetNotifier()
		);

		switch ($response) {
			case PasswordBroker::RESET_LINK_SENT:
				event(new Events\PasswordResetEmailSent($request->get('email'), Date::now()));

				flash()->success(_m('success-exclamation'), _m('auth-password-link-sent'));
			break;

			case PasswordBroker::INVALID_USER:
				event(new Events\PasswordResetEmailFailed($request->get('email'), $response, Date::now()));

				flash()->error(_m('error-exclamation'), _m('auth-password-invalid-user'));
			break;
		}

		return back();
	}

	protected function resetNotifier()
	{
		return function ($message) {
			$message->subject(_m('auth-password-subject'));
		};
	}

	protected function sendResetLinkResponse($response)
	{
		flash()->success(_m('success-exclamation'), _m('auth-password-link-sent'));

		return back();
	}

	protected function sendResetLinkFailedResponse(Request $request, $response)
	{
		switch ($response) {
			case PasswordBroker::INVALID_USER:
				event(new Events\PasswordResetEmailFailed($request->get('email'), $response));

				flash()->error(_m('error-exclamation'), _m('auth-password-invalid-user'));
				
				return back();
			break;

			case PasswordBroker::INVALID_PASSWORD:
				event(new Events\PasswordResetEmailFailed($request->get('email'), $response, Date::now()));

				flash()->error(_m('error-exclamation'), _m('auth-password-requirements'));
				
				return back()->withInput($request->only('email'));
			break;

			case PasswordBroker::INVALID_TOKEN:
				event(new Events\PasswordResetEmailFailed($request->get('email'), $response, Date::now()));

				flash()->error(_m('error-exclamation'), _m('auth-password-invalid-token'));
				
				return back();
			break;
		}
	}
}
