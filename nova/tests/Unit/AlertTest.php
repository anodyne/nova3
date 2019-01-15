<?php

namespace Tests\Unit;

use Tests\TestCase;
use Nova\Foundation\Alert;

class AlertTest extends TestCase
{
    protected $alert;

    public function setUp()
    {
        parent::setUp();

        $this->alert = $this->app->make(Alert::class);
    }

    /** @test **/
    public function it_can_set_a_message()
    {
        $this->alert->withMessage('Message');

        $this->assertEquals('Message', $this->alert->getData('message'));
    }

    /** @test **/
    public function it_can_set_a_title()
    {
        $this->alert->withTitle('Title');

        $this->assertEquals('Title', $this->alert->getData('title'));
    }

    /** @test **/
    public function it_can_set_a_type_of_error()
    {
        $this->alert->error();

        $this->assertEquals('error', $this->alert->getData('type'));
        $this->assertTrue(session()->has('alert'));
        $this->assertEquals('error', session('alert.type'));
    }

    /** @test **/
    public function it_can_set_a_type_of_info()
    {
        $this->alert->info();

        $this->assertEquals('info', $this->alert->getData('type'));
        $this->assertTrue(session()->has('alert'));
        $this->assertEquals('info', session('alert.type'));
    }

    /** @test **/
    public function it_can_set_a_type_of_success()
    {
        $this->alert->success();

        $this->assertEquals('success', $this->alert->getData('type'));
        $this->assertTrue(session()->has('alert'));
        $this->assertEquals('success', session('alert.type'));
    }

    /** @test **/
    public function it_can_set_a_type_of_warning()
    {
        $this->alert->warning();

        $this->assertEquals('warning', $this->alert->getData('type'));
        $this->assertTrue(session()->has('alert'));
        $this->assertEquals('warning', session('alert.type'));
    }

    /** @test **/
    public function it_can_require_interaction_from_the_user()
    {
        $this->alert->persist();

        $this->assertTrue($this->alert->getData('persist'));
        $this->assertNull($this->alert->getData('type'));
    }

    /** @test **/
    public function it_can_use_dynamic_methods_to_persist_alerts()
    {
        $this->alert->persistSuccess();

        $this->assertTrue($this->alert->getData('persist'));
        $this->assertEquals('success', $this->alert->getData('type'));
    }
}