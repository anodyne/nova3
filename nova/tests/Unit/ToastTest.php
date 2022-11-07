<?php

declare(strict_types=1);

use Nova\Foundation\Toast;
use Tests\TestCase;

/**
 * @group toast
 */
class ToastTest extends TestCase
{
    protected Toast $toast;

    public function setUp(): void
    {
        parent::setUp();

        $this->toast = app(Toast::class);
    }

    /** @test */
    public function itCanSetTheToastMessage()
    {
        $this->toast->withMessage('Message');

        $this->assertSame($this->toast->message, 'Message');
    }

    /** @test */
    public function itCanSetTheActionText()
    {
        $this->toast->withActionText('Save');

        $this->assertSame($this->toast->actionText, 'Save');
    }

    /** @test */
    public function itCanSetTheActionUrl()
    {
        $this->toast->withActionLink('https://google.com');

        $this->assertSame($this->toast->actionLink, 'https://google.com');
    }

    /** @test */
    public function itCanSetAnErrorType()
    {
        $this->toast->error();

        $this->assertEquals($this->toast->type, 'error');
    }

    /** @test */
    public function itCanSetASuccessType()
    {
        $this->toast->success();

        $this->assertEquals($this->toast->type, 'success');
    }
}
