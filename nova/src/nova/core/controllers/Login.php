<?php namespace Nova\Core\Controllers;

/**
 * Controller that handles requests for the "login" section of Nova.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

use URL;
use Date;
use Html;
use Mail;
use Input;
use Sentry;
use Session;
use Location;
use Redirect;
use UserValidator;
use LoginBaseController;

class Login extends LoginBaseController {

	/**
	 * Lets a user log in to the system. If their email address or password is wrong,
	 * they're notified of the error. Also handles notifying the user if they've
	 * been locked out of the system for too many log in attempts.
	 */
	public function getIndex($error = self::OK)
	{
		// Set the view
		$this->_view = 'login/index';

		// Only show the error messages when there's something wrong
		if ($error > self::OK)
		{
			// Set the error class
			$errorStatus = 'danger';

			switch ($error)
			{
				case self::NOT_LOGGED_IN:
					$errorMsg = lang("login.error.notLoggedIn");
				break;

				case self::NO_EMAIL:
					$errorMsg = lang("login.error.noEmail");
				break;

				case self::NO_PASSWORD:
					$errorMsg = lang("login.error.noPassword");
				break;

				case self::NOT_FOUND:
					$errorMsg = lang("login.error.notFound");
				break;

				case self::SUSPENDED:
					$errorMsg = lang("login.error.suspended", Session::get('suspended_time'));
				break;

				case self::BANNED:
					$errorMsg = lang("login.error.banned");
				break;
			}

			// Set the flash data
			$this->_flash[] = array(
				'status' 	=> $errorStatus,
				'content' 	=> $errorMsg,
				'class'		=> 'alert-danger',
			);
		}
	}
	public function postIndex()
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
			// Grab the credentials
			$email = e(Input::get('email'));
			$password = e(Input::get('password'));

			// Attempt to log in
			$user = Sentry::authenticateAndRemember(array(
				'email'		=> $email,
				'password'	=> $password,
			));

			// Get the Sentry cookie
			$persistCookie = Sentry::getCookie()->getCookie();

			return Redirect::to('admin/index')->withCookie($persistCookie);
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::to('login/error/'.self::NOT_FOUND)->withInput();
		}
		catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
			// Get the throttle record
			$throttle = Sentry::getThrottleProvider()->findByLogin($email);

			// Get the suspended date into a usable format
			$suspendedAt = Date::instance($throttle->suspended_at)
				->addMinutes($throttle->getSuspensionTime());

			// Get now
			$now = Date::now('UTC');

			return Redirect::to('login/error/'.self::SUSPENDED)
				->withInput()
				->with('suspended_time', $suspendedAt->diffInMinutes($now));
		}
		catch (\Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
			return Redirect::to('login/error/'.self::BANNED);
		}
	}

	/**
	 * Logs a user out of the system, destroys any cookies, and make sure they
	 * won't be remembered by the system.
	 */
	public function getLogout()
	{
		// Do the logout
		Sentry::logout();

		// Flush the session for safe measure
		Session::flush();

		return Redirect::to('/');
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
		$this->_view = 'login/reset';

		// Get the reset success message
		$flash = Session::get('reset_step1', null);

		if ($flash == 'success')
		{
			$this->_flash[] = array(
				'status' 	=> 'success',
				'message' 	=> lang('login.reset.step1Success'),
			);
		}

		if ($flash === 'failure')
		{
			$this->_flash[] = array(
				'status' 	=> 'danger',
				'message' 	=> lang('login.reset.step1Failure'),
			);
		}
	}
	public function postReset()
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
			// Grab the credentials
			$email = e(Input::get('email'));

			// Get the user
			$user = Sentry::getUserProvider()->findByLogin($email);

			// Get the password reset code
			$resetCode = $user->getResetPasswordCode();

			// Build the content for the email
			$data['title'] = lang('email.subject.passwordReset');
			$data['content'] = lang('email.content.passwordReset', URL::to("login/reset_confirm/{$user->id}/{$resetCode}"));

			// Get the settings for use in the closure
			$settings = $this->settings;

			// Send the email
			Mail::send([Location::email('login/reset', 'html'), Location::email('login/reset', 'text')], 
					$data, function($m) use($user, $settings)
			{
				$m->from($settings->email_address, $settings->email_name);
				$m->to($user->email);
				$m->subject($settings->email_subject.' '.lang('email.subject.passwordReset'));
			});

			// Set up the data to flash to the next request
			$flashData = array('reset_step1' => 'success');
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Set up the data to flash to the next request
			$flashData = array('reset_step1' => 'failure');
		}

		return Redirect::to('login/reset')->with($flashData);
	}

	// TODO: need some kind of procedure for how to handle if the email doesn't go out
	// TODO: need something in the admin side of things here a GM can manually confirm a password reset

	/**
	 * Confirms a user's request to reset their password.
	 */
	public function getResetConfirm($id, $code)
	{
		// Set the view
		$this->_view = 'login/reset_confirm';

		// Set the data
		$this->_data->user = $id;
		$this->_data->code = $code;
		$this->_data->confirmed = false;

		// Get the reset triggers
		$confirm = Session::get('reset_confirmation', null);
		$reset = Session::get('reset_step2', null);

		if ($confirm === true)
		{
			if ($reset === true)
			{
				$this->_flash[] = array(
					'status' 	=> 'success',
					'message' 	=> lang('login.reset.step2Success', HTML::link('login', ucfirst(lang('action.login')))),
				);

				$this->_data->confirmed = true;
				$this->_data->message = false;
			}
			elseif ($reset === false)
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('login.reset.step2Failure'),
				);
			}
		}
		elseif ($confirm === false)
		{
			$this->_flash[] = array(
				'status' 	=> 'danger',
				'message' 	=> lang('login.reset.confirmationFailed'),
			);
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
			$user = Sentry::getUserProvider()->findById($id);

			// Check the reset code against what we have in the database
			if ($user->checkResetPasswordCode($code))
			{
				// Attempt to reset the user password
				if ($user->attemptResetPassword($code, $newPassword))
				{
					// Set up the data to flash to the next request
					$flashData = array(
						'reset_confirmation' => true,
						'reset_step2' => true
					);
				}
				else
				{
					// Set up the data to flash to the next request
					$flashData = array(
						'reset_confirmation' => true,
						'reset_step2' => false
					);
				}
			}
			else
			{
				// Set up the data to flash to the next request
				$flashData = array(
					'reset_confirmation' => false,
				);
			}
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Set up the data to flash to the next request
			$flashData = array(
				'reset_confirmation' => false,
			);
		}

		return Redirect::to('login/reset_confirm')->with($flashData);
	}

}