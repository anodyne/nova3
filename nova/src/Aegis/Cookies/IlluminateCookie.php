<?php namespace Nova\Aegis\Cookies;

use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;

class IlluminateCookie implements CookieInterface {

	protected $request;
	protected $jar;
	protected $key = 'nova_aegis';

	public function __construct(Request $request, CookieJar $jar, $key = null)
	{
		$this->request = $request;
		$this->jar = $jar;

		if (isset($key))
		{
			$this->key = $key;
		}
	}

	public function put($value)
	{
		$cookie = $this->jar->forever($this->key, $value);

		$this->jar->queue($cookie);
	}

	public function get()
	{
		$key = $this->key;

		$queued = $this->jar->queued($key);

		if (isset($queued[$key]))
		{
			return $queued[$key];
		}

		return $this->request->cookie($key);
	}

	public function forget()
	{
		$cookie = $this->jar->forget($this->key);

		$this->jar->queue($cookie);
	}

}