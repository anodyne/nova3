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

        $this->assertEquals('Message', $this->alert->message);
    }

    /** @test **/
    public function it_can_set_a_type_of_error()
    {
        $this->alert->error();

        $this->assertEquals('is-danger', $this->alert->type);
    }

    /** @test **/
    public function it_can_set_a_type_of_success()
    {
        $this->alert->success();

        $this->assertEquals('is-success', $this->alert->type);
    }

    /** @test **/
    public function it_can_be_a_toast_notification()
    {
        $this->alert->toast()->dark();

        $this->assertTrue($this->alert->toast);
        $this->assertTrue(session()->has('nova.notices.toast'));
    }

    /** @test **/
    public function it_can_use_dynamic_methods_to_create_toast_alerts()
    {
        $this->alert->toastSuccess();

        $this->assertTrue($this->alert->toast);
        $this->assertEquals('is-success', $this->alert->type);
    }

    /** @test **/
    public function it_can_be_positioned()
    {
        $this->alert->position('top-left');

        $this->assertEquals('is-top-left', $this->alert->position);
    }

    /** @test **/
    public function it_can_use_dynamic_methods_to_position_alerts()
    {
        $this->alert->atTop();

        $this->assertEquals('is-top', $this->alert->position);
    }
}
