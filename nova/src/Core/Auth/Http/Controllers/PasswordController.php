<?php namespace Nova\Core\Auth\Http\Controllers;

use Flash, BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard,
	Illuminate\Contracts\Auth\PasswordBroker,
	Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends BaseController {

	protected $auth;
	protected $passwords;

	public function __construct(Application $app, Guard $auth, PasswordBroker $passwords)
	{
		parent::__construct($app);

		$this->auth = $auth;
		$this->passwords = $passwords;
		$this->structureView = 'auth';
		$this->templateView = 'auth';
	}

	public function getEmail()
	{
		$this->view = 'auth/password';
	}

	public function postEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email']);

		$response = $this->passwords->sendResetLink($request->only('email'), function($m)
		{
			$m->subject($this->getEmailSubject());
		});

		switch ($response)
		{
			case PasswordBroker::RESET_LINK_SENT:
				Flash::success("Your password reset link has been sent!");
			break;

			case PasswordBroker::INVALID_USER:
				Flash::error("No user with that email address found!");
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

		$this->view = 'auth/reset';
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

		$response = $this->passwords->reset($credentials, function($user, $password)
		{
			$user->password = $password;

			$user->save();

			$this->auth->login($user);
		});

		switch ($response)
		{
			case PasswordBroker::PASSWORD_RESET:
				Flash::success('Your password has been reset!');
				return redirect()->route('home');
			break;

			case PasswordBroker::INVALID_USER:
				Flash::error('No user with that email address found!');
				return redirect()->back();
			break;

			case PasswordBroker::INVALID_PASSWORD:
				Flash::error('Passwords must be at least six characters and match the confirmation.');
				return redirect()->back()->withInput($request->only('email'));
			break;

			case PasswordBroker::INVALID_TOKEN:
				Flash::error('This password reset token is invalid.');
				return redirect()->back();
			break;
		}
	}

}
