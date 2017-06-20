<?php namespace Tests\Unit;

use Tests\TestCase;
use Nova\Foundation\TranslationFileLoader;

class TranslationFileLoaderTest extends TestCase
{
	protected $loader;

	public function setUp()
	{
		parent::setUp();

		$this->loader = new TranslationFileLoader(
			$this->app['files'],
			$this->app['path.lang'],
			$this->app['path.nova.lang']
		);

		$this->loader->load('en', '*', '*');
	}
	/** @test **/
	public function it_can_create_a_loader()
	{
		$this->assertInstanceOf(TranslationFileLoader::class, $this->loader);
	}

	/** @test **/
	public function it_loads_language_file_from_the_nova_core()
	{
		$this->assertArrayHasKey('email-address', $this->loader->getNovaLangItems());
		$this->assertEquals($this->loader->getNovaLangItems()['email-address'], 'Email Address');
	}

	public function it_loads_language_file_from_outside_the_nova_core()
	{
		// Given we have a JSON file outside the Nova core
		// Load it
		// And we should be able to see all of those items in the loader
	}

	public function it_can_override_nova_core_language_items()
	{
		// Given we have a key that's the same both inside and outside the Nova core
		// Access the item
		// And we should see the item from outside the Nova core
	}
}
