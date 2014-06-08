<?php namespace Nova\Aegis\Persistence;

class AegisPersistence implements PersistenceInterface {

	protected $session;
	protected $cookie;

	public function __construct(SessionInterface $session, CookieInterface $cookie)
	{
		$this->session = $session;
		$this->cookie = $cookie;
	}

	public function check()
	{
		if ($code = $this->session->get())
		{
			return $code;
		}

		if ($code = $this->cookie->get())
		{
			return $code;
		}
	}

	public function add(PersistableInterface $persistable, $remember = false)
	{
		// Generate a persistence code
		$code = $persistable->generatePersistenceCode();

		// Put the code into the session
		$this->session->put($code);

		// If we're remembering the user, put the code into a cookie
		if ($remember)
		{
			$this->cookie->put($code);
		}

		// Add the persistence code to the database
		$persistable->addPersistenceCode($code);
	}

	public function addAndRemember(PersistableInterface $persistable)
	{
		$this->add($persistable, true);
	}

	public function remove(PersistableInterface $persistable)
	{
		$code = $this->check();

		if ($code === null)
		{
			return;
		}

		$this->session->forget();
		$this->cookie->forget();

		return $persistable->removePersistenceCode($code);
	}

	public function flush(PersistableInterface $persistable)
	{
		$this->session->forget();
		$this->cookie->forget();

		foreach ($persistable->getPersistenceCodes() as $code)
		{
			$persistable->removePersistenceCode($code);
		}
	}

}