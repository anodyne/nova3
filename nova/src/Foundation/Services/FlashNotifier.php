<?php namespace Nova\Foundation\Services;

class FlashNotifier {

	public function create($message, $title = null, $level = 'info', $key = 'flash_message')
	{
		session()->flash($key, [
			'title'		=> $title,
			'message'	=> $message,
			'level'		=> $level,
		]);
	}

	public function error($message, $title = null)
	{
		return $this->create($message, $title, 'error');
	}

	public function info($message, $title = null)
	{
		return $this->create($message, $title, 'info');
	}

	public function success($message, $title = null)
	{
		return $this->create($message, $title, 'success');
	}

	public function warning($message, $title = null)
	{
		return $this->create($message, $title, 'warning');
	}

	public function overlay($message, $title = null, $level = null)
	{
		return $this->create($message, $title, $level, 'flash_message_overlay');
	}

}