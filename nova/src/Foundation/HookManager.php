<?php namespace Nova\Foundation;

class HookManager {

	protected $hooks = [
		'nova.before-render',
		'nova.after-render',
	];
	protected $listeners = [
		'nova.before-render' => [],
		'nova.after-render' => [],
	];

	public function call($name, array $args = [])
	{
		$params = [
			'route' => request()->route(),
			'controller' => app('nova.controller'),
			'theme' => theme(),
		];

		foreach ($args as $key => $value) {
			$params[$key] = $value;
		}

		foreach ($this->listeners[$name] as $listener) {
			if (is_string($listener)) {
				list($class, $method) = explode('@', $listener);

				echo call_user_func_array([new $class, $method], $params);
			}

			if (is_callable($listener)) {
				echo call_user_func_array($listener, $params);
			}
		}
	}

	public function listen($hookName, $callback)
	{
		$this->listeners[$hookName][] = $callback;

		return $this;
	}

	public function add($hookName)
	{
		$this->hooks[] = $hookName;
		$this->listeners[$hookName] = [];

		return $this;
	}
}