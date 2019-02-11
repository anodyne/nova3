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
    public function it_can_set_action_text()
    {
        $this->alert->withActionText('Save');

        $this->assertEquals('Save', $this->alert->actionText);
    }

    /** @test **/
    public function it_can_set_action_url()
    {
        $this->alert->withActionLink('https://google.com');

        $this->assertEquals('https://google.com', $this->alert->actionLink);
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
}
