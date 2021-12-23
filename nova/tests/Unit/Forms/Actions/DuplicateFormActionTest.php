<?php

declare(strict_types=1);

namespace Tests\Unit\Forms\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Forms\Actions\DuplicateForm;
use Nova\Forms\Models\Form;
use Tests\TestCase;

/**
 * @group forms
 */
class DuplicateFormActionTest extends TestCase
{
    use RefreshDatabase;

    protected $form;

    public function setUp(): void
    {
        parent::setUp();

        $this->form = Form::factory()->create();
    }

    /** @test **/
    public function itDuplicatesAForm()
    {
        $form = DuplicateForm::run($this->form);

        $this->assertEquals(
            "Copy of {$this->form->name}",
            $form->name
        );
    }
}
