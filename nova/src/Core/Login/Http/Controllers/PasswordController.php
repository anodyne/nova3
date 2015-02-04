<?php namespace Nova\Core\Login\Http\Controllers;

use Flash, Input, BaseController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard,
	Illuminate\Contracts\Auth\PasswordBroker,
	Illuminate\Contracts\Foundation\Application;

class PasswordController extends BaseController {

	protected $auth;
	protected $passwords;

	public function __construct(Application $app, Guard $auth,
			PasswordBroker $passwords)
	{
		parent::__construct($app);

		$this->auth = $auth;
		$this->passwords = $passwords;
		$this->structureView = 'login';
		$this->templateView = 'login';
	}

	public function email()
	{
		$this->view = 'login/password-email';
	}

	public function emailReset(Request $request)
	{
		$this->validate($request, ['email' => 'required']);

		$response = $this->passwords->sendResetLink($request->only('email'), function($m)
		{
			$m->subject($this->getEmailSubject());
		});

		switch ($response)
		{
			case PasswordBroker::RESET_LINK_SENT:
				return redirect()->back()->with('status', trans($response));

			case PasswordBroker::INVALID_USER:
				return redirect()->back()->withErrors(['email' => trans($response)]);
		}
	}

	public function reset($token)
	{
		$this->view = 'login/password-reset';
		$this->data->token = $token;
	}

	public function resetPassword(Request $request)
	{
		$this->validate($request, [
			'token' => 'required',
			'email' => 'required',
			'password' => 'required|confirmed',
		]);

		$credentials = $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = $this->passwords->reset($credentials, function($user, $password)
		{
			$user->password = bcrypt($password);

			$user->save();

			$this->auth->login($user);
		});

		switch ($response)
		{
			case PasswordBroker::PASSWORD_RESET:
				return redirect()->route('home');

			default:
				return redirect()->back()
					->withInput($request->only('email'))
					->withErrors(['email' => trans($response)]);
		}
	}

}
