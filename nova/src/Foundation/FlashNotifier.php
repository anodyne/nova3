<?php namespace Nova\Foundation;

use Illuminate\Session\SessionManager;

class FlashNotifier
{
	protected $title;
	protected $session;
	protected $message;

	public function __construct(SessionManager $session)
	{
		$this->session = $session;
	}

	public function message($value)
	{
		$this->message = $value;

		return $this;
	}

	public function title($value)
	{
		$this->title = $value;

		return $this;
	}

	public function create($title = null, $message = null, $level = 'info', $key = 'flash')
	{
		$title = ($title) ?: $this->title;
		$message = ($message) ?: $this->message;

		$this->session->flash($key, [
			'title'		=> $title,
			'message'	=> $message,
			'level'		=> $level,
		]);
	}

	public function error($title = null, $message = null)
	{
		return $this->create($title, $message, 'danger');
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
