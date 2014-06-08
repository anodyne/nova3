<?php namespace Nova\Aegis\Sessions;

use Illuminate\Session\Store as SessionStore;

class IlluminateSession implements SessionInterface {

	protected $session;
	protected $key = 'nova_aegis';

	public function __construct(SessionStore $session, $key = null)
	{
		$this->session = $session;

		if (isset($key))
		{
			$this->key = $key;
		}
	}

	public function put($value)
	{
		$this->session->put($this->key, $value);
	}

	public function get()
	{
		return $this->session->get($this->key);
	}

	public function forget()
	{
		return $this->session->forget($this->key);
	}

}