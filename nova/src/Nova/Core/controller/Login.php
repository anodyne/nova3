<?php namespace Nova\Core\Controller;

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
use Input;
use Sentry;
use Session;
use Utility;
use Redirect;
use LoginBaseController;

class Login extends LoginBaseController {

	/**
	 * Lets a user log in to the system. If their email address or password is wrong,
	 * they're notified of the error. Also handles notifying the user if they've
	 * been locked out of the system for too many log in attempts.
	 */
	public function getIndex()
	{
		// Set the view
		$this->_view = 'login/index';

		// Get the error code
		$error = $this->request->segment(3);

		// Only show the error messages when there's something wrong
		if ($error > self::OK)
		{
			switch ($error)
			{
				case self::NOT_LOGGED_IN:
					$errorStatus = 'danger';
					$errorMsg = lang("error.login.notLoggedIn");
				break;

				case self::NO_EMAIL:
					$errorStatus = 'danger';
					$errorMsg = lang("error.login.noEmail");
				break;

				case self::NO_PASSWORD:
					$errorStatus = 'danger';
					$errorMsg = lang("error.login.noPassword");
				break;

				case self::NOT_FOUND:
					$errorStatus = 'danger';
					$errorMsg = lang("error.login.notFound");
				break;

				case self::SUSPENDED:
					$errorStatus = 'danger';
					$errorMsg = lang("error.login.suspended", Session::get('suspended_time'));
				break;

				case self::BANNED:
					$errorStatus = 'danger';
					$errorMsg = lang("error.login.banned");
				break;
			}

			// set the flash data
			$this->_flash[] = array(
				'status' 	=> $errorStatus,
				'message' 	=> $errorMsg,
			);
		}
	}
	public function postIndex()
	{
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

			return Redirect::to('login/authenticated');
			//return Redirect::to('admin/main/index');
		}
		catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			return Redirect::to('login/index/'.self::NO_EMAIL);
		}
		catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			return Redirect::to('login/index/'.self::NO_PASSWORD);
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::to('login/index/'.self::NOT_FOUND);
		}
		catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
			// Get the throttle record
			$throttle = Sentry::getThrottleProvider()->findByUserLogin($email);

			// Get the suspended date into a usable format
			$suspendedAt = Date::createFromFormat('Y-m-d H:i:s', $throttle->suspended_at);

			// Get now
			$now = Date::now();

			// Flash the remaining lock out time
			Session::flash('suspended_time', $suspendedAt->diffInMinutes($now));

			return Redirect::to('login/index/'.self::SUSPENDED);
		}
		catch (\Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
			return Redirect::to('login/index/'.self::BANNED);
		}
	}

	/**
	 * Logs a user out of the system, destroys any cookies, and make sure they
	 * won't be remembered by the system.
	 */
	public function getLogout()
	{
		// Do the log out
		Sentry::logout();

		return Redirect::to('main/index');
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
		$this->_view = 'login/reset';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// grab the data from the POST and filter it
				$email = \Security::xss_clean(\Input::post('email'));
				$password = \Security::xss_clean(\Input::post('password'));

				try
				{
					// do the reset
					$reset = \Sentry::resetPassword($email, $password);

					if ($reset)
					{
						// set the email address coming from the reset
						$address = $reset['email'];

						// create the confirmation link
						$link = URL::to('login/reset_confirm/'.$reset['link']);

						// parse the content for the message
						$email_content = lang('email.content.passwordReset', $link);

						// set up the email
						$email = \Email::forge();
						$email->from($this->settings->email_address, $this->settings->email_name)
							->to($address)
							->subject($this->settings->email_subject.' '.lang('email.subject.passwordReset'))
							->body($email_content);

						try
						{
							// send the email
							$email->send();

							$this->_flash[] = array(
								'status' 	=> 'success',
								'message' 	=> lang('short.login.resetSuccess')
							);
						}
						catch(\EmailValidationFailedException $e)
						{
							$this->_flash[] = array(
								'status' 	=> 'danger',
								'message' 	=> lang('error.email.validationFailed')
							);
						}
						catch(\EmailSendingFailedException $e)
						{
							$this->_flash[] = array(
								'status' 	=> 'danger',
								'message' 	=> lang('error.email.couldNotSend')
							);
						}
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> lang('error.login.resetFailed')
						);
					}
				}
				catch (\SentryAuthException $e)
				{
					$this->_flash[] = array(
						'status' 	=> 'danger',
						'message' 	=> lang('error.login.authException')
					);
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}
	}

	# TODO: need some kind of procedure for how to handle if the email doesn't go out
	# TODO: need something in the admin side of things here a GM can manually confirm a password reset

	/**
	 * Confirms a user's request to reset their password.
	 */
	public function getReset_confirm()
	{
		$this->_view = 'login/reset_confirm';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				try
				{
					// confirm password reset
					$confirm_reset = \Sentry::resetPasswordConfirm(\Uri::segment(3), \Uri::segment(4));

					if ($confirm_reset)
					{
						// redirect to the login page with a message about a successful reset
						\Response::redirect('login/index/'.self::PASS_RESET);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> lang('error.login.confirmationFailed')
						);
					}
				}
				catch (\SentryAuthException $e)
				{
					$this->_flash[] = array(
						'status' 	=> 'danger',
						'message' 	=> lang('error.login.authException')
					);
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}
	}

	public function getAuthenticated()
	{
		d(Sentry::getUser());
	}

}