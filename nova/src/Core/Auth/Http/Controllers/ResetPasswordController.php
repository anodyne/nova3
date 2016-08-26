<?php namespace Nova\Core\Auth\Http\Controllers;

use Date, BaseController;
use Nova\Core\Auth\Events;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends BaseController {

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
		event(new Events\PasswordReset(request()->get('email'), Date::now()));

		flash()->success("Success!", "Your password has been reset.");
		
		return redirect()->route('home');
	}

	protected function sendResetFailedResponse(Request $request, $response)
	{
		switch ($response)
		{
			case PasswordBroker::INVALID_USER:
				event(new Events\PasswordResetFailed($request->get('email'), $response));

				flash()->error("Error!", "No user with that email address found.");
				
				return redirect()->back();
			break;

			case PasswordBroker::INVALID_PASSWORD:
				event(new Events\PasswordResetFailed($request->get('email'), $response, Date::now()));

				flash()->error("Error!", "Passwords must be at least six characters and match the confirmation.");
				
				return redirect()->back()->withInput($request->only('email'));
			break;

			case PasswordBroker::INVALID_TOKEN:
				event(new Events\PasswordResetFailed($request->get('email'), $response, Date::now()));

				flash()->error("Error!", "This password reset token is invalid.");
				
				return redirect()->back();
			break;
		}
	}
}
