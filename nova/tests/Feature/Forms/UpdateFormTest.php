<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormUpdated;
use Nova\Forms\Models\Form;
use Nova\Forms\Requests\UpdateFormRequest;
use Tests\TestCase;

/**
 * @group forms
 */
class UpdateFormTest extends TestCase
{
    use RefreshDatabase;

    protected $form;

    public function setUp(): void
    {
        parent::setUp();

        $this->form = Form::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewTheEditFormPage()
    {
        $this->signInWithPermission('form.update');

        $response = $this->get(route('forms.edit', $this->form));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateForm()
    {
        $this->signInWithPermission('form.update');

        $form = Form::factory()->make();

        $this->followingRedirects();

        $response = $this->put(
            route('forms.update', $this->form),
            array_merge($form->toArray(), [
                'id' => $this->form->id,
            ])
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('forms', $form->only('key', 'name'));

        $this->assertRouteUsesFormRequest(
            'forms.update',
            UpdateFormRequest::class
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenFormIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('form.update');

        $this->put(
            route('forms.update', $this->form),
            Form::factory()->make()->toArray()
        );

        Event::assertDispatched(FormUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditFormPage()
    {
        $this->signIn();

        $response = $this->get(route('forms.edit', $this->form));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateForm()
    {
        $this->signIn();

        $response = $this->putJson(
            route('forms.update', $this->form),
            Form::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditFormPage()
    {
        $response = $this->getJson(route('forms.edit', $this->form));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateForm()
    {
        $response = $this->putJson(
            route('forms.update', $this->form),
            Form::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }

    /** @test **/
    public function lockedFormKeyCannotBeUpdated()
    {
        $form = Form::factory()->locked()->create();

        $this->signInWithPermission('form.update');

        $response = $this->put(route('forms.update', $form), [
            'name' => 'Foo',
            'key' => 'foo',
        ]);

        $this->assertDatabaseHas('forms', [
            'id' => $form->id,
            'name' => 'Foo',
            'key' => $form->key,
            'locked' => true,
        ]);
    }
}
