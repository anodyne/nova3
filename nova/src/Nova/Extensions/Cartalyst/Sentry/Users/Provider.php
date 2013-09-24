<?php namespace Nova\Extensions\Cartalyst\Sentry\Users;

use UserModel;
use Cartalyst\Sentry\Hashing\HasherInterface;
use Cartalyst\Sentry\Groups\GroupInterface;
use Cartalyst\Sentry\Users\ProviderInterface;
use Cartalyst\Sentry\Users\UserInterface;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Users\UserNotFoundException;

class Provider implements ProviderInterface {

	/**
	 * The Eloquent user model.
	 *
	 * @var string
	 */
	protected $model = 'UserModel';

	/**
	 * The hasher for the model.
	 *
	 * @var Cartalyst\Sentry\Hashing\HasherInterface
	 */
	protected $hasher;

	/**
	 * Create a new Eloquent User provider.
	 *
	 * @param  Cartalyst\Sentry\Hashing\HasherInterface  $hasher
	 * @param  string  $model
	 * @return void
	 */
	public function __construct(HasherInterface $hasher, $model = null)
	{
		$this->hasher = $hasher;

		if (isset($model))
		{
			$this->model = $model;
		}

		$this->setupHasherWithModel();
	}

	/**
	 * Finds a user by the given user ID.
	 *
	 * @param  mixed  $id
	 * @return Cartalyst\Sentry\Users\UserInterface
	 * @throws Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findById($id)
	{
		$model = $this->createModel();

		if ( ! $user = $model->newQuery()->find($id))
		{
			throw new UserNotFoundException("A user could not be found with ID [$id].");
		}

		return $user;
	}

	/**
	 * Finds a user by the login value.
	 *
	 * @param  string  $login
	 * @return Cartalyst\Sentry\Users\UserInterface
	 * @throws Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByLogin($login)
	{
		$model = $this->createModel();

		if ( ! $user = $model->newQuery()->where($model->getLoginName(), '=', $login)->first())
		{
			throw new UserNotFoundException("A user could not be found with a login value of [$login].");
		}

		return $user;
	}

	/**
	 * Finds a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return Cartalyst\Sentry\Users\UserInterface
	 * @throws Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByCredentials(array $credentials)
	{
		$model = $this->createModel();

		if ( ! array_key_exists(($attribute = $model->getLoginName()), $credentials))
		{
			throw new \InvalidArgumentException("Login attribute [$attribute] was not provided.");
		}

		$query              = $model->newQuery();
		$hashableAttributes = $model->getHashableAttributes();
		$hashedCredentials  = array();

		// build query from given credentials
		foreach ($credentials as $credential => $value)
		{
			// Remove hashed attributes to check later as we need to check these
			// values after we retrieved them because of salts
			if (in_array($credential, $hashableAttributes))
			{
				$hashedCredentials = array_merge($hashedCredentials, array($credential => $value));
			}
			else
			{
				$query = $query->where($credential, '=', $value);
			}
		}

		if ( ! $user = $query->first())
		{
			throw new UserNotFoundException("A user was not found with the given credentials.");
		}

		// Now check the hashed credentials match ours
		foreach ($hashedCredentials as $credential => $value)
		{
			if ( ! $this->hasher->checkHash($value, $user->{$credential}))
			{
				throw new UserNotFoundException("A user was found to match all plain text credentials however hashed credential [$credential] did not match.");
			}
		}

		return $user;
	}

	/**
	 * Finds a user by the given activation code.
	 *
	 * @param  string  $code
	 * @return Cartalyst\Sentry\Users\UserInterface
	 * @throws RuntimeException
	 * @throws Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByActivationCode($code)
	{
		return UserModel::where('activation_hash', $code)->first();
	}

	/**
	 * Finds a user by the given reset password code.
	 *
	 * @param  string  $code
	 * @return Cartalyst\Sentry\Users\UserInterface
	 * @throws RuntimeException
	 * @throws Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function findByResetPasswordCode($code)
	{
		return UserModel::where('reset_password_hash', $code)->first();
	}

	/**
	 * Returns an all users.
	 *
	 * @return array
	 */
	public function findAll()
	{
		return $this->createModel()->newQuery()->get()->all();
	}

	/**
	 * Returns all users with access to
	 * a permission(s).
	 *
	 * @param  string|array  $permissions
	 * @return array
	 */
	public function findAllWithAccess($permissions)
	{
		return array_filter($this->findAll(), function($user) use ($permissions)
		{
			return $user->hasAccess($permissions);
		});
	}

	/**
	 * Creates a user.
	 *
	 * @param  array  $credentials
	 * @return Cartalyst\Sentry\Users\UserInterface
	 */
	public function create(array $credentials)
	{
		$user = $this->createModel();
		$user->fill($credentials);
		$user->save();

		return $user;
	}

	/**
	 * Returns an empty user object.
	 *
	 * @return Cartalyst\Sentry\Users\UserInterface
	 */
	public function getEmptyUser()
	{
		return $this->createModel();
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
		$this->setupHasherWithModel();
	}

	/**
	 * Statically sets the hasher with the model.
	 *
	 * @return void
	 */
	public function setupHasherWithModel()
	{
		if (method_exists($this->model, 'setHasher'))
		{
			forward_static_call_array(array($this->model, 'setHasher'), array($this->hasher));
		}
	}

	/**
	 * Returns all users with access to
	 * any given permission(s).
	 *
	 * @param  array  $permissions
	 * @return array
	 */
	public function findAllWithAnyAccess(array $permissions)
	{
		return $permissions;
	}

	/**
	 * Returns all users who belong to
	 * a group.
	 *
	 * @param  Cartalyst\Sentry\Groups\GroupInterface  $group
	 * @return array
	 */
	public function findAllInGroup($group)
	{
		return array_filter($this->findAll(), function($user) use ($group)
		{
			return $user->inGroup($group);
		});
	}

}