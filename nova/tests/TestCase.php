<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * The base URL to use while testing the application.
	 *
	 * @var string
	 */
	protected $baseUrl = 'http://nova3.dev';

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		if (Storage::disk('local')->has('nova-installed.json'))
			Storage::disk('local')->delete('nova-installed.json');

		return $app;
	}

}
