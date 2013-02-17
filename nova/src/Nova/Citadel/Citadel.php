<?php namespace Nova\Citadel;

class Citadel {

	protected $user;

	public function __construct()
	{
		# code...
	}

	public function user($id = null)
	{
		if ($id)
		{
			$this->user = new User($id);
		}

		return $this->user;
	}
}
