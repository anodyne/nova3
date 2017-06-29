<?php namespace Tests\Unit;

use Tests\TestCase;

class FlashNotifierTest extends TestCase
{
	/** @test **/
	public function it_sends_a_success_message()
	{
		flash()->success('Title', 'Message');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'success');

		flash()->title('Title')->message('Message')->success();

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'success');

		flash()->title('Title')->success(null, 'Message');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'success');

		flash()->message('Message')->success('Title');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'success');

		flash('message', 'title', 'success');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'success');
	}

	/** @test **/
	public function it_sends_a_warning_message()
	{
		flash()->warning('Title', 'Message');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'warning');

		flash()->title('Title')->message('Message')->warning();

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'warning');

		flash()->title('Title')->warning(null, 'Message');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'warning');

		flash()->message('Message')->warning('Title');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'warning');

		flash('message', 'title', 'warning');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'warning');
	}

	/** @test **/
	public function it_sends_an_error_message()
	{
		flash()->error('Title', 'Message');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'danger');

		flash()->title('Title')->message('Message')->error();

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'danger');

		flash()->title('Title')->error(null, 'Message');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'danger');

		flash()->message('Message')->error('Title');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'danger');

		flash('message', 'title', 'danger');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'danger');
	}

	/** @test **/
	public function it_sends_an_info_message()
	{
		flash()->info('Title', 'Message');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'info');

		flash()->title('Title')->message('Message')->info();

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'info');

		flash()->title('Title')->info(null, 'Message');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'info');

		flash()->message('Message')->info('Title');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'info');

		flash('message', 'title', 'info');

		$this->assertEquals(session('flash.message'), 'Message');
		$this->assertEquals(session('flash.title'), 'Title');
		$this->assertEquals(session('flash.level'), 'info');
	}
}
