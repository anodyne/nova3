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
		$code = $persistable->generatePersistenceCode();

		$this->session->put($code);

		if ($remember)
		{
			$this->cookie->put($code);
		}

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