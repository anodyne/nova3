<?php namespace Nova\Core\Controllers;

use Event,
	Input,
	Session,
	Redirect,
	ErrorCode,
	UserValidator,
	LoginBaseController;
use Cartalyst\Sentry\Users\UserNotFoundException,
	Cartalyst\Sentry\Throttling\UserBannedException,
	Cartalyst\Sentry\Throttling\UserSuspendedException;

class LoginController extends LoginBaseController {

	/**
	 * Lets a user log in to the system. If their email address or password is
	 * wrong, they're notified of the error. Also handles notifying the user
	 * if they've been locked out of the system for too many log in attempts.
	 */
	public function index($error = ErrorCode::LOGIN_OK)
	{
		// Set the view
		$this->view = 'login/index';

		// Only show the error messages when there's something wrong
		if ($error > ErrorCode::LOGIN_OK)
		{
			// Set the error class
			$errorStatus = 'danger';

			switch ($error)
			{
				case ErrorCode::LOGIN_NOT_LOGGED_IN:
					$errorMsg = lang("login.error.notLoggedIn");
				break;

				case ErrorCode::LOGIN_NO_EMAIL:
					$errorMsg = lang("login.error.noEmail");
				break;

				case ErrorCode::LOGIN_NO_PASSWORD:
					$errorMsg = lang("login.error.noPassword");
				break;

				case ErrorCode::LOGIN_NOT_FOUND:
					$errorMsg = lang("login.error.notFound");
				break;

				case ErrorCode::LOGIN_SUSPENDED:
					$errorMsg = lang("login.error.suspended", Session::get('suspended_time'));
				break;

				case ErrorCode::LOGIN_BANNED:
					$errorMsg = lang("login.error.banned");
				break;

				case ErrorCode::LOGIN_NOT_ADMIN:
					$errorMsg = lang("login.error.notAdmin");
				break;
			}

			// Set the flash data
			$this->flash[] = [
				'content' 	=> $errorMsg,
				'class'		=> "alert-{$errorStatus}",
			];
		}
	}
	public function postIndex()
	{
		// Set up the validation server
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
			return Redirect::back()->withInput()->withErrors($validator->getErrors());

		try
		{
			// Attempt log in
			$user = $this->auth->authenticateAndRemember([
				'email'		=> Input::get('email'),
				'password'	=> Input::get('password'),
			]);

			// Get the Sentry cookie
			$persistCookie = $this->auth->getCookie();

			// If the user was redirected, send them to where they were trying to go
			if (Session::has('url.intended'))
				return Redirect::intended('admin')->withCookie($persistCookie);
			else
				return Redirect::to('admin')->withCookie($persistCookie);
		}
		catch (UserNotFoundException $e)
		{
			return Redirect::to('login/error/'.ErrorCode::LOGIN_NOT_FOUND)->withInput();
		}
		catch (UserSuspendedException $e)
		{
			return Redirect::to('login/error/'.ErrorCode::LOGIN_SUSPENDED)
				->withInput()
				->with('suspended_time', $this->auth->getSuspendedTimeRemaining(Input::get('email')));
		}
		catch (UserBannedException $e)
		{
			return Redirect::to('login/error/'.ErrorCode::LOGIN_BANNED);
		}
	}

	/**
	 * Logs a user out of the system, destroys any cookies, and make sure they
	 * won't be remembered by the system.
	 */
	public function logout()
	{
		// Do the logout
		$this->auth->logout();

		// Get the Sentry cookie
		$persistCookie = $this->auth->getCookie();

		return Redirect::to('/')->withCookie($persistCookie);
	}

	/**
	 * Lets a user reset their password to one of their choosing. Once they've
	 * entered their email address and new password, they'll receive an email
	 * with a confirmation link. After clicking on the confirmation link and
	 * clicking the button the page, the password will be updated. In the event
	 * they remember their password, logging in to the system will cancel the
	 * reset request.
	 */
	public function getReset()
	{
		// Set the view
		$this->view = 'login/reset';

		// Get the reset success message
		$flash = Session::get('reset_step1', null);

		if ($flash == 'success')
		{
			$this->flash[] = [
				'class' 	=> 'alert-success',
				'message' 	=> lang('login.reset.step1Success'),
			];
		}

		if ($flash === 'failure')
		{
			$this->flash[] = [
				'class' 	=> 'alert-danger',
				'message' 	=> lang('login.reset.step1Failure'),
			];
		}
	}
	public function postReset()
	{
		// Set up the validation server
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
			return Redirect::back()->withInput()->withErrors($validator->getErrors());

		try
		{
			// Grab the credentials
			$email = Input::get('email');

			// Get the user
			$user = $this->auth->getUserProvider()->findByLogin($email);

			// Fire the user password reset event
			Event::fire('nova.user.resetPassword', $user);

			// Set up the data to flash to the next request
			$flashData = ['reset_step1' => 'success'];
		}
		catch (UserNotFoundException $e)
		{
			// Set up the data to flash to the next request
			$flashData = ['reset_step1' => 'failure'];
		}

		return Redirect::to('login/reset')->with($flashData);
	}

	// TODO: need some kind of procedure for how to handle if the email doesn't go out
	// TODO: need something in the admin side of things where a GM can manually confirm a password reset

	/**
	 * Confirms a user's request to reset their password.
	 */
	public function getResetConfirm($id, $code)
	{
		// Set the view
		$this->view = 'login/reset_confirm';

		// Set the data
		$this->data->user = $id;
		$this->data->code = $code;
		$this->data->confirmed = false;

		// Get the reset triggers
		$confirm = Session::get('reset_confirmation', null);
		$reset = Session::get('reset_step2', null);

		if ($confirm === true)
		{
			if ($reset === true)
			{
				$this->flash[] = [
					'class' 	=> 'alert-success',
					'message' 	=> lang('login.reset.step2Success', HTML::link('login', lang('Action.login'))),
				];

				$this->data->confirmed = true;
				$this->data->message = false;
			}
			elseif ($reset === false)
			{
				$this->flash[] = [
					'class' 	=> 'alert-danger',
					'message' 	=> lang('login.reset.step2Failure'),
				];
			}
		}
		elseif ($confirm === false)
		{
			$this->flash[] = [
				'class' 	=> 'alert-danger',
				'message' 	=> lang('login.reset.confirmationFailed'),
			];
		}
	}
	public function postResetConfirm($id, $code)
	{
		// Set up the validation server
		$validator = new UserValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		try
		{
			// Get the data from the input array
			$newPassword = Input::get('password');

			// Get the user
			$user = $this->auth->getUserProvider()->findById($id);

			// Check the reset code against what we have in the database
			if ($user->checkResetPasswordCode($code))
			{
				// Attempt to reset the user password
				if ($user->attemptResetPassword($code, $newPassword))
				{
					// Set up the data to flash to the next request
					$flashData = [
						'reset_confirmation'	=> true,
						'reset_step2'			=> true
					];
				}
				else
				{
					// Set up the data to flash to the next request
					$flashData = [
						'reset_confirmation'	=> true,
						'reset_step2'			=> false
					];
				}
			}
			else
			{
				// Set up the data to flash to the next request
				$flashData = ['reset_confirmation' => false];
			}
		}
		catch (UserNotFoundException $e)
		{
			// Set up the data to flash to the next request
			$flashData = ['reset_confirmation' => false];
		}

		return Redirect::to('login/reset_confirm')->with($flashData);
	}

}