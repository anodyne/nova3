<?php namespace Nova\Foundation;

use Illuminate\Session\SessionManager;

class FlashNotifier
{
	protected $session;

	public function __construct(SessionManager $session)
	{
		$this->session = $session;
	}

	public function create($title = null, $message = null, $level = 'info', $key = 'flash')
	{
		$this->session->flash($key, [
			'title'		=> $title,
			'message'	=> $message,
			'level'		=> $level,
		]);
	}

	public function error($title = null, $message = null)
	{
		return $this->create($title, $message, 'error');
	}

	public function info($title = null, $message = null)
	{
		return $this->create($title, $message, 'info');
	}

	public function success($title = null, $message = null)
	{
		return $this->create($title, $message, 'success');
	}

	public function warning($title = null, $message = null)
	{
		return $this->create($title, $message, 'warning');
	}
}
