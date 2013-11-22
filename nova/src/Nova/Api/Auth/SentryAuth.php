<?php namespace Nova\Api\Auth;
/**
 * Part of the API package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    API
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Illuminate\Http\Request;

class SentryAuth implements AuthInterface {

	/**
	 * Sentry instance.
	 *
	 * @var Cartalyst\Sentry\Sentry
	 */
	protected $sentry;

	/**
	 * Create a new Platform instance.
	 *
	 * @param  Cartalyst\Sentry\Sentry  $sentry
	 * @return void
	 */
	public function __construct(Sentry $sentry)
	{
		$this->sentry = $sentry;
	}

	/**
	 * Authenticate a user for the current request.
	 *
	 * @param  Illuminate\Http\Request  $request
	 * @return bool
	 */
	public function authenticate(Request $request)
	{
		$login    = $request->getUser();
		$password = $request->getPassword();

		try
		{
			return (bool) $this->sentry->authenticate(compact('login', 'password'));
		}
		catch (UserBannedException $e)
		{
			return false;
		}
		catch (UserSuspendedException $e)
		{
			return false;
		}
		catch (LoginRequiredException $e)
		{
			return false;
		}
		catch (PasswordRequiredException $e)
		{
			return false;
		}
		catch (UserNotFoundException $e)
		{
			return false;
		}
	}

}