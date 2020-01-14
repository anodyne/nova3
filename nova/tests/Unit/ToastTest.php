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

    /**
     * @test
     */
    public function itCanSetMessage()
    {
        $this->toast->withMessage('Message');

        $this->assertEquals('Message', $this->toast->message);
    }

    /**
     * @test
     */
    public function itCanSetActionText()
    {
        $this->toast->withActionText('Save');

        $this->assertEquals('Save', $this->toast->actionText);
    }

    /**
     * @test
     */
    public function itCanSetActionUrl()
    {
        $this->toast->withActionLink('https://google.com');

        $this->assertEquals('https://google.com', $this->toast->actionLink);
    }

    /**
     * @test
     */
    public function itCanSetErrorType()
    {
        $this->toast->error();

        $this->assertEquals('is-danger', $this->toast->type);
    }

    /**
     * @test
     */
    public function itCanSetSuccessType()
    {
        $this->toast->success();

        $this->assertEquals('is-success', $this->toast->type);
    }
}
