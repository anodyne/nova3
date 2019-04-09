<?php

namespace Tests\Unit;

use Tests\TestCase;
use Nova\Foundation\Toast;

class ToastTest extends TestCase
{
    protected $toast;

    public function setUp(): void
    {
        parent::setUp();

        $this->toast = $this->app->make(Toast::class);
    }

    public function testItCanSetMessage()
    {
        $this->toast->withMessage('Message');

        $this->assertEquals('Message', $this->toast->message);
    }

    public function testItCanSetActionText()
    {
        $this->toast->withActionText('Save');

        $this->assertEquals('Save', $this->toast->actionText);
    }

    public function testItCanSetActionUrl()
    {
        $this->toast->withActionLink('https://google.com');

        $this->assertEquals('https://google.com', $this->toast->actionLink);
    }

    public function testItCanSetErrorType()
    {
        $this->toast->error();

        $this->assertEquals('is-danger', $this->toast->type);
    }

    public function testItCanSetSuccessType()
    {
        $this->toast->success();

        $this->assertEquals('is-success', $this->toast->type);
    }
}
