<?php namespace Tests;

use Nova\Foundation\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	protected $oldExceptionHandler;

	protected function setUp()
	{
		parent::setUp();

		$this->disableExceptionHandling();
	}

	protected function signIn($user = null)
	{
		$user = ($user) ?: create('User');

		$this->actingAs($user);
	}

	protected function disableExceptionHandling()
	{
		$this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

		$this->app->instance(ExceptionHandler::class, new class extends Handler {
			public function __construct() {}
			public function report(\Exception $e) {}
			public function render($request, \Exception $e) {
				throw $e;
			}
		});
	}

	protected function withExceptionHandling()
	{
		$this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

		return $this;
	}
}
