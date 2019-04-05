<?php

namespace Tests\Unit;

use Tests\TestCase;
use Nova\Foundation\Alert;

class AlertTest extends TestCase
{
    protected $alert;

    public function setUp(): void
    {
        parent::setUp();

        $this->alert = $this->app->make(Alert::class);
    }

    public function testItCanSetMessage()
    {
        $this->alert->withMessage('Message');

        $this->assertEquals('Message', $this->alert->message);
    }

    public function testItCanSetActionText()
    {
        $this->alert->withActionText('Save');

        $this->assertEquals('Save', $this->alert->actionText);
    }

    public function testItCanSetActionUrl()
    {
        $this->alert->withActionLink('https://google.com');

        $this->assertEquals('https://google.com', $this->alert->actionLink);
    }

    public function testItCanSetErrorType()
    {
        $this->alert->error();

        $this->assertEquals('is-danger', $this->alert->type);
    }

    public function testItCanSetSuccessType()
    {
        $this->alert->success();

        $this->assertEquals('is-success', $this->alert->type);
    }
}
