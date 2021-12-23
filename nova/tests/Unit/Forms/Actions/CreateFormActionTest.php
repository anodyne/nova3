<?php

declare(strict_types=1);

namespace Tests\Unit\Forms\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Forms\Actions\CreateForm;
use Nova\Forms\Data\FormData;
use Tests\TestCase;

/**
 * @group forms
 */
class CreateFormActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function itCreatesAForm()
    {
        $data = FormData::from([
            'key' => 'foo',
            'name' => 'Foo',
            'description' => 'Description of foo',
            'locked' => false,
        ]);

        $form = CreateForm::run($data);

        $this->assertTrue($form->exists);
        $this->assertEquals('Foo', $form->name);
        $this->assertEquals('foo', $form->key);
        $this->assertEquals('Description of foo', $form->description);
    }
}
