<?php

use Mockery as m;
use Way\Tests\Assert;
use Nova\Core\Lib\Nova;
use Nova\Core\Lib\TestCase;
use Nova\Extensions\Laravel\Application;

class NovaTest extends TestCase {

	protected $nova;

	public function tearDown()
	{
		m::close();
	}

	/**
	 * @covers	Nova::getIconIndex
	 */
	public function testIconIndexReturnsArray()
	{
		App::instance('nova.common', m::mock(['getIconIndex' => array()]));
		
		$actual = $this->nova->getIconIndex('foo');

		Assert::type('array', $actual);
	}

}