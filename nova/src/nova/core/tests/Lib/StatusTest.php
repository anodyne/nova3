<?php

use Mockery as m;
use Nova\Core\Lib\Status;
use Nova\Core\Lib\TestCase;

class StatusTest extends TestCase {

	/**
	 * @covers	Status::toInt
	 */
	public function testConvertsToInt()
	{
		// The expected output
		$expected = 1;

		// Mock the Status class
		$mock = m::mock('Status');
		$mock->shouldReceive('toInt')->once()->andReturn($expected);

		// Make sure we get what we expect
		$this->assertSame($expected, $mock->toInt('pending'));
	}

	/**
	 * @covers				Status::toInt
	 * @expectedException	Exception
	 */
	public function testConvertsToIntThrowsExceptionOnBadStatus()
	{
		// The expected output
		$expected = 1;

		// Mock the Status class
		$mock = m::mock('Status');
		$mock->shouldReceive('toInt')->once()->andReturn($expected);

		// Make sure we get what we expect
		$mock->toInt('foo');
	}

	/**
	 * @covers				Status::toInt
	 * @expectedException	Exception
	 */
	public function testConvertsToIntThrowsExceptionOnNonString()
	{
		// The expected output
		$expected = 1;

		// Mock the Status class
		$mock = m::mock('Status');
		$mock->shouldReceive('toInt')->once()->andReturn($expected);

		// Make sure we get what we expect
		$mock->toInt(12);
	}

	/**
	 * @covers	Status::toString
	 */
	public function testConvertsToString()
	{
		// The expected output
		$expected = lang('pending');

		// Mock the Status class
		$mock = m::mock('Status');
		$mock->shouldReceive('toString')->once()->andReturn($expected);

		// Make sure we get what we expect
		$this->assertSame($expected, $mock->toString(1));
	}

	/**
	 * @covers				Status::toString
	 * @expectedException	Exception
	 */
	public function testConvertsToStringThrowsExceptionOnBadStatus()
	{
		// The expected output
		$expected = lang('pending');

		// Mock the Status class
		$mock = m::mock('Status');
		$mock->shouldReceive('toInt')->once()->andReturn($expected);

		// Make sure we get what we expect
		$mock->toInt(999);
	}

	/**
	 * @covers				Status::toString
	 * @expectedException	Exception
	 */
	public function testConvertsToStringThrowsExceptionOnNonInteger()
	{
		// The expected output
		$expected = lang('pending');

		// Mock the Status class
		$mock = m::mock('Status');
		$mock->shouldReceive('toInt')->once()->andReturn($expected);

		// Make sure we get what we expect
		$mock->toInt('foo');
	}

}