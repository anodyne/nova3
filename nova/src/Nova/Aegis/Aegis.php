<?php namespace Nova\Aegis;

use Illuminate\Events\Dispatcher;
use Nova\Aegis\Persistence\PersistenceInterface;

class Aegis {
  
	protected $user;
	protected $users;
	protected $roles;

	/**
	 * Persistence driver.
	 * @var		Nova\Aegis\Persistence\PersistenceInterface
	 */
	protected $persistence;

	protected $permissions;

	/**
	 * Event dispatcher.
	 * @var		Illuminate\Event\Dispatcher
	 */
	protected $dispatcher;
  
	public function __construct(PersistenceInterface $persistence, Dispatcher $dispatcher)
	{
		$this->persistence = $persistence;
		//$this->users = $users;
		//$this->roles = $roles;
		$this->dispatcher = $dispatcher;
	}
  
	/**
	 * Authenticate a user.
	 * 
	 * @param    array     $credentials    Email/password credentials
	 * @param    bool      $login          If authenticated, should the user be logged in?
	 * @param    bool      $remember       Should the user be persisted?
	 * @return   bool
	 */
	public function authenticate(array $credentials, $login = false, $remember = true)
	{
		$this->fireEvent('authenticating');

		$this->fireEvent('authenticated');
	}
  
	/**
	 * Can the current logged in user take action on the component type?
	 * 
	 * @param    string    $action    The action
	 * @param    string    $component The component type
	 * @return   bool
	 */
	public function can($action, $component)
	{
		return $this->checkPermissions($action, $component);
	}
  
	/**
	 * Can the current logged in user not take action on the component type?
	 * 
	 * @param    string    $action    The action
	 * @param    string    $component The component type
	 * @return   bool
	 */
	public function cannot($action, $component)
	{
		return ! $this->checkPermissions($action, $component);
	}
  
	/**
	 * Check to see if the current user is logged in.
	 * 
	 * @return   bool
	 */
	public function check()
	{
		if ($this->user !== null)
		{
			return $this->user;
		}

		if ( ! $code = $this->persistence->check())
		{
			return false;
		}

		if ( ! $user = $this->users->findByPersistenceCode($code))
		{
			return false;
		}

		return $this->user = $user;
	}
  
	/**
	 * Log a user in.
	 * 
	 * @param    array     $credentials    Email/password combination
	 * @param    bool      $remember       Should the user be persisted?
	 * @return   bool
	 */
	public function login(array $credentials, $remember = true)
	{
		$this->fireEvent('loggingIn');

		// Authenticate

		// If authentication failed, return false

		// If authentication succeeded and we don't want to log in, return true

		// If authentication succeeded and we want to be logged in, continue...

		// If we want to be remembered, set up persistence

		$this->fireEvent('loggedIn');
	}
  
	/**
	 * Log the current user out.
	 * 
	 * @return   void
	 */
	public function logout($everywhere = false)
	{
		$this->fireEvent('loggingOut');

		// Grab the user
		$user = $this->getUser();

		// If there is no user, no need to continue
		if ($user === null)
		{
			return true;
		}

		// Figure out if we're flushing everything or just this instance
		$method = ($everywhere === true) ? 'flush' : 'remove';

		// Clear the persistent record(s)
		$this->persistence->{$method}($user);

		$this->fireEvent('loggedOut');
	}

	/**
	 * Authenticate statelessly.
	 *
	 * @param	array	$credentials
	 * @return	bool
	 */
	public function stateless(array $credentials)
	{
		return $this->authenticate($credentials, false, false);
	}

	/**
	 * Get the current user.
	 *
	 * @param	bool	$check	Check for the current user?
	 * @return	UserModel
	 */
	public function getUser($check = true)
	{
		if ($check === true and $this->user === null)
		{
			$this->check();
		}

		return $this->user;
	}

	/**
	 * Set the user.
	 *
	 * @param	UserInterface	$user
	 * @return	void
	 */
	public function setUser(UserInterface $user)
	{
		$this->user = $user;
	}

	/**
	 * Get the event dispatcher.
	 *
	 * @return	Dispatcher
	 */
	public function getEventDispatcher()
	{
		return $this->dispatcher;
	}

	/**
	 * Set the event dispatcher.
	 *
	 * @param	Dispatcher	$dispatcher
	 * @return	void
	 */
	public function setEventDispatcher(Dispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}
  
	/**
	 * Build the user's permissions from their roles.
	 * 
	 * @internal
	 * @return    array
	 */
	protected function buildPermissions()
	{
		// Get the user

		// Get the user's role(s)

		// Build the permissions array and store it on the object
	}
  
	/**
	 * Parse the action and component type to see if the current logged in
	 * user can do what's being requested.
	 * 
	 * @internal
	 * @param    string    $action    The action
	 * @param    string    $component The component type
	 * @return   bool
	 */
	protected function checkPermissions($action, $component)
	{
		// Parse the action and component

		// Compare to $permissions

		// Return the result
	}

	protected function fireEvent($event, array $payload = [], $halt = false)
	{
		if ( ! $dispatcher = $this->getEventDispatcher()) return;

		$method = ($halt) ? 'until' : 'fire';

		return $dispatcher->{$method}("nova.aegis.{$event}", $payload);
	}

}