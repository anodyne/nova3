<?php

namespace Nova\Citadel\Throttling;

use UserSuspendedModel;
use Cartalyst\Sentry\Throttling\ThrottleInterface;
use Cartalyst\Sentry\Throttling\ProviderInterface;
use Cartalyst\Sentry\Users\ProviderInterface as UserProviderInterface;

class Provider implements ProviderInterface {

	/**
	 * The Eloquent throttle model.
	 *
	 * @var string
	 */
	protected $model = 'UserSuspend';

	/**
	 * The user provider used for finding users
	 * to attach throttles to.
	 *
	 * @var Cartalyst\Sentry\Users\UserInterface
	 */
	protected $userProvider;

	/**
	 * Throttling status.
	 *
	 * @var bool
	 */
	protected $enabled = true;

	/**
	 * Creates a new throttle provider.
	 *
	 * @param  Cartalyst\Sentry\Users\UserInterface  $userProvider
	 * @return void
	 */
	public function __construct(UserProviderInterface $userProvider, $model=null)
	{
		$this->userProvider = $userProvider;
		if (isset($model))
		{
			$this->model = $model;
		}

	}

	/**
	 * Finds a throttler by the given user ID.
	 *
	 * @param  mixed  $id
	 * @return Cartalyst\Sentry\Throttling\ThrottleInterface
	 */
	public function findByUserId($id, $ipAddress = null)
	{
		$user  = $this->userProvider->findById($id);
		$model = $this->createModel();
		$query = $model->where('user_id', '=', ($userId = $user->getId()));

		if ($ipAddress)
		{
			$query->where('ip_address', '=', $ipAddress);
		}

		if ( ! $throttle = $query->first())
		{
			$throttle = $this->createModel();
			$throttle->user_id = $userId;
			$throttle->save();
		}

		return $throttle;
	}

	/**
	 * Finds a throttling interface by the given user login.
	 *
	 * @param  string  $login
	 * @param  string  $ipAddress
	 * @return Cartalyst\Sentry\Throttling\ThrottleInterface
	 */
	public function findByUserLogin($login, $ipAddress = null)
	{
		$user  = $this->userProvider->findByLogin($login);
		$model = $this->createModel();
		$query = $model->where('user_id', '=', ($userId = $user->getId()));

		if ($ipAddress)
		{
			$query->where('ip_address', '=', $ipAddress);
		}

		if ( ! $throttle = $query->first())
		{
			$throttle = $this->createModel();
			$throttle->user_id = $userId;
			if ($ipAddress) $throttle->ip_address = $ipAddress;
			$throttle->save();
		}

		return $throttle;
	}

	/**
	 * Enable throttling.
	 *
	 * @return void
	 */
	public function enable()
	{
		$this->enabled = true;
	}

	/**
	 * Disable throttling.
	 *
	 * @return void
	 */
	public function disable()
	{
		$this->enabled = false;
	}

	/**
	 * Check if throttling is enabled.
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		return $this->enabled;
	}

	/**
	 * Create a new instance of the model.
	 *
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function createModel()
	{
		$class = '\\'.ltrim($this->model, '\\');

		return new $class;
	}

	/**
	 * Sets a new model class name to be used at
	 * runtime.
	 *
	 * @param  string  $model
	 */
	public function setModel($model)
	{
		$this->model = $model;
	}

}
