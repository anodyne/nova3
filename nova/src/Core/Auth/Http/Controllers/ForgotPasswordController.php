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

		switch ($response)
		{
			case PasswordBroker::RESET_LINK_SENT:
				event(new Events\PasswordResetEmailSent($request->get('email'), Date::now()));

				flash()->success("Success!", "Your password reset link has been sent.");
			break;

			case PasswordBroker::INVALID_USER:
				event(new Events\PasswordResetEmailFailed($request->get('email'), $response, Date::now()));

				flash()->error("Error!", "No user with that email address found.");
			break;
		}

		return redirect()->back();
	}

	protected function resetNotifier()
	{
		return function ($message) {
			$message->subject('Your Password Reset Link');
		};
	}
}
