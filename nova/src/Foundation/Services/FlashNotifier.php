<?php namespace Nova\Foundation\Services;

use Illuminate\Session\Store as SessionStore;

class FlashNotifier {

	protected $session;

	public function __construct(SessionStore $session)
	{
		$this->session = $session;
	}

	public function error($message, $header = false)
	{
		$this->session->flash('flash.level', 'danger');
		$this->session->flash('flash.message', $message);
		$this->session->flash('flash.header', $header);
	}

	public function info($message, $header = false)
	{
		$this->session->flash('flash.level', 'info');
		$this->session->flash('flash.message', $message);
		$this->session->flash('flash.header', $header);
	}

	public function success($message, $header = false)
	{
		$this->session->flash('flash.level', 'success');
		$this->session->flash('flash.message', $message);
		$this->session->flash('flash.header', $header);
	}

	public function warning($message, $header = false)
	{
		$this->session->flash('flash.level', 'warning');
		$this->session->flash('flash.message', $message);
		$this->session->flash('flash.header', $header);
	}

}