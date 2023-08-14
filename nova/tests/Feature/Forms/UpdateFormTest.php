<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormUpdated;
use Nova\Forms\Models\Form;
use Nova\Forms\Requests\UpdateFormRequest;
beforeEach(function () {
    $this->form = Form::factory()->create();
});
test('authorized user can view the edit form page', function () {
    $this->signInWithPermission('form.update');

    $response = $this->get(route('forms.edit', $this->form));
    $response->assertSuccessful();
});
test('authorized user can update form', function () {
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
});
test('event is dispatched when form is updated', function () {
    Event::fake();

    $this->signInWithPermission('form.update');

    $this->put(
        route('forms.update', $this->form),
        Form::factory()->make()->toArray()
    );

    Event::assertDispatched(FormUpdated::class);
});
test('unauthorized user cannot view the edit form page', function () {
    $this->signIn();

    $response = $this->get(route('forms.edit', $this->form));
    $response->assertForbidden();
});
test('unauthorized user cannot update form', function () {
    $this->signIn();

    $response = $this->putJson(
        route('forms.update', $this->form),
        Form::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the edit form page', function () {
    $response = $this->getJson(route('forms.edit', $this->form));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update form', function () {
    $response = $this->putJson(
        route('forms.update', $this->form),
        Form::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
test('locked form key cannot be updated', function () {
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
});
