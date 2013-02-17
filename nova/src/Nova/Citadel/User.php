<?php namespace Nova\Citadel;

use UserModel;

class User {

	protected $user;

	public function __construct($id)
	{
		$this->user = UserModel::find($id);
	}
}
