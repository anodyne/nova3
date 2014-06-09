<?php namespace Nova\Aegis\Users;

use Closure;

interface UserRepositoryInterface {

	public function findById($id);

	public function findByCredentials(array $credentials);

	public function findByPersistenceCode($code);

	public function recordLogin(UserInterface $user);

	public function validateCredentials(UserInterface $user, array $credentials);

}