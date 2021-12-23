<?php

declare(strict_types=1);

namespace Tests\Unit\Forms\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Forms\Actions\UpdateForm;
use Nova\Forms\Data\FormData;
use Nova\Forms\Models\Form;
use Tests\TestCase;

/**
 * @group forms
 */
class UpdateFormActionTest extends TestCase
{
    use RefreshDatabase;

    protected $form;

    public function setUp(): void
    {
        parent::setUp();

        $this->form = Form::factory()->create();
    }

    /** @test **/
    public function itCanUpdateAForm()
    {
        $data = FormData::from([
            'key' => 'foo',
            'name' => 'Foo',
            'description' => 'New description of foo',
            'locked' => $this->form->locked,
        ]);

        $form = UpdateForm::run($this->form, $data);

        $this->assertEquals('foo', $form->key);
        $this->assertEquals('Foo', $form->name);
        $this->assertEquals('New description of foo', $form->description);
    }

    /** @test **/
    public function itCannotUpdateTheKeyOfALockedForm()
    {
        $lockedForm = Form::factory()->locked()->create();

        $data = FormData::from([
            'key' => 'foo',
            'name' => 'Foo',
            'description' => 'New description of foo',
            'locked' => $lockedForm->locked,
        ]);

        $form = UpdateForm::run($lockedForm, $data);

        $this->assertEquals($lockedForm->key, $form->key);
        $this->assertEquals('Foo', $form->name);
        $this->assertEquals('New description of foo', $form->description);
    }
}
