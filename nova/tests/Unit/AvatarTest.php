<?php namespace Tests\Unit;

use Nova\Users\User;
use Nova\Foundation\Avatar;
use Tests\DatabaseTestCase;

class AvatarTest extends DatabaseTestCase
{
	protected $user;
	protected $avatar;

	public function setUp()
	{
		parent::setUp();
		
		$this->user = make(User::class);
		$this->avatar = (new Avatar)->setUser($this->user);
	}
	
	/** @test **/
	public function it_sets_a_user()
	{
		$this->assertInstanceOf('Nova\Users\User', $this->avatar->getUser());
	}

	/** @test **/
	public function it_sets_the_fallback_image()
	{
		$this->avatar->default('foo');

		$this->assertArrayHasKey('default', $this->avatar->getOptions());
		$this->assertEquals('foo', $this->avatar->getOptions()['default']);
	}

	/** @test **/
	public function it_sets_the_image_type()
	{
		$this->avatar->image();

		$this->assertArrayHasKey('type', $this->avatar->getOptions());
		$this->assertEquals('image', $this->avatar->getOptions()['type']);
	}

	/** @test **/
	public function it_sets_the_link_type()
	{
		$this->avatar->link();

		$this->assertArrayHasKey('type', $this->avatar->getOptions());
		$this->assertEquals('link', $this->avatar->getOptions()['type']);
	}
}
