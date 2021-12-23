<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormDuplicated;
use Nova\Forms\Models\Form;
use Tests\TestCase;

/**
 * @group forms
 */
class DuplicateFormTest extends TestCase
{
    use RefreshDatabase;

    protected $form;

    public function setUp(): void
    {
        parent::setUp();

        $this->form = Form::factory()->create([
            'key' => 'foo',
            'name' => 'Foo',
        ]);
    }

    /** @test **/
    public function authorizedUserCanDuplicateForm()
    {
        $this->signInWithPermission(['form.create', 'form.update']);

        $this->followingRedirects();

        $response = $this->post(route('forms.duplicate', $this->form));
        $response->assertSuccessful();

        $this->assertDatabaseHas('forms', [
            'name' => "Copy of {$this->form->name}",
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenFormIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['form.create', 'form.update']);

        $this->post(route('forms.duplicate', $this->form));

        Event::assertDispatched(FormDuplicated::class);
    }

    /** @test **/
    public function lockedFormCannotBeDuplicated()
    {
        $form = Form::factory()->locked()->create();

        $this->signInWithPermission(['form.create', 'form.update']);

        $formCount = Form::count();

        $response = $this->postJson(route('forms.duplicate', $form));
        $response->assertForbidden();

        $this->assertEquals($formCount, Form::count());
    }

    /** @test **/
    public function unauthorizedUserCannotDuplicateForm()
    {
        $this->signIn();

        $response = $this->post(route('forms.duplicate', $this->form));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDuplicateForm()
    {
        $response = $this->postJson(route('forms.duplicate', $this->form));
        $response->assertUnauthorized();
    }
}
