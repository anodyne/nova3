<?php namespace Nova\Foundation\Services;

class FlashNotifier
{
	public function create($title = null, $message = null, $level = 'info', $key = 'flash_message')
	{
		session()->flash($key, [
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

	public function overlay($title = null, $message = null, $level = null)
	{
		return $this->create($title, $message, $level, 'flash_message_overlay');
	}
}
