<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormCreated;
use Nova\Forms\Models\Form;
use Nova\Forms\Requests\CreateFormRequest;
use Tests\TestCase;

/**
 * @group forms
 */
class CreateFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanViewTheCreateFormPage()
    {
        $this->signInWithPermission('form.create');

        $response = $this->get(route('forms.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateForm()
    {
        $this->signInWithPermission('form.create');

        $form = Form::factory()->make();

        $this->followingRedirects();

        $response = $this->post(route('forms.store'), $form->toArray());
        $response->assertSuccessful();

        $this->assertDatabaseHas('forms', $form->only('name', 'key'));

        $this->assertRouteUsesFormRequest(
            'forms.store',
            CreateFormRequest::class
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenFormIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('form.create');

        $this->post(route('forms.store'), Form::factory()->make()->toArray());

        Event::assertDispatched(FormCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateFormPage()
    {
        $this->signIn();

        $response = $this->get(route('forms.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateForm()
    {
        $this->signIn();

        $response = $this->postJson(
            route('forms.store'),
            Form::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreateFormPage()
    {
        $response = $this->getJson(route('forms.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateForm()
    {
        $response = $this->postJson(
            route('forms.store'),
            Form::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
