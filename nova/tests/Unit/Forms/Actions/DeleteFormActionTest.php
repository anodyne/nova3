<?php

declare(strict_types=1);

namespace Tests\Unit\Forms\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Forms\Actions\DeleteForm;
use Nova\Forms\Models\Form;
use Tests\TestCase;

/**
 * @group forms
 */
class DeleteFormActionTest extends TestCase
{
    use RefreshDatabase;

    protected Form $form;

    public function setUp(): void
    {
        parent::setUp();

        $this->form = Form::factory()->create();
    }

    /** @test **/
    public function itDeletesAForm()
    {
        $form = DeleteForm::run($this->form);

        $this->assertFalse($form->exists);
    }
}
