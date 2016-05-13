<?php namespace Nova\Core\Auth\Http\Controllers;

use Date, BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\{Guard, PasswordBroker};
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends BaseController {

	protected $auth;
	protected $passwords;

	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		parent::__construct();

		$this->views->put('structure', 'auth');
		$this->views->put('template', 'auth');

		$this->auth = $auth;
		$this->passwords = $passwords;
	}

	public function getEmail()
	{
		$this->views->put('page', 'auth/password');
	}

	public function postEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email']);

		$response = $this->passwords->sendResetLink($request->only('email'), function ($m)
		{
			$m->subject($this->getEmailSubject());
		});

		switch ($response)
		{
			case PasswordBroker::RESET_LINK_SENT:
				event(new Events\PasswordResetEmailSent($request->get('email')));

				flash()->success("Success!", "Your password reset link has been sent.");
			break;

			case PasswordBroker::INVALID_USER:
				event(new Events\PasswordResetEmailFailed($request->get('email'), $response));

				flash()->error("Error!", "No user with that email address found.");
			break;
		}

		return redirect()->back();
	}

	protected function getEmailSubject()
	{
		return isset($this->subject) ? $this->subject : 'Your Password Reset Link';
	}

	public function getReset($token = null)
	{
		if (is_null($token))
		{
			throw new NotFoundHttpException;
		}

		$this->views->put('page', 'auth/reset');
		$this->data->token = $token;
	}

	public function postReset(Request $request)
	{
		$this->validate($request, [
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed',
		]);

		$credentials = $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = $this->passwords->reset($credentials, function ($user, $password)
		{
			$user->password = $password;
			$user->last_password_reset = Date::now();

			$user->save();

			$this->auth->login($user);
		});

		switch ($response)
		{
			case PasswordBroker::PASSWORD_RESET:
				event(new Events\PasswordReset($request->get('email')));

				flash()->success("Success!", "Your password has been reset.");
				
				return redirect()->route('home');
			break;

			case PasswordBroker::INVALID_USER:
				event(new Events\PasswordResetFailed($request->get('email'), $response));

				flash()->error("Error!", "No user with that email address found.");
				
				return redirect()->back();
			break;

			case PasswordBroker::INVALID_PASSWORD:
				event(new Events\PasswordResetFailed($request->get('email'), $response));

				flash()->error("Error!", "Passwords must be at least six characters and match the confirmation.");
				
				return redirect()->back()->withInput($request->only('email'));
			break;

			case PasswordBroker::INVALID_TOKEN:
				event(new Events\PasswordResetFailed($request->get('email'), $response));

				flash()->error("Error!", "This password reset token is invalid.");
				
				return redirect()->back();
			break;
		}
	}

}
