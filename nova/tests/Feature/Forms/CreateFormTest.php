<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormCreated;
use Nova\Forms\Models\Form;
use Nova\Forms\Requests\CreateFormRequest;
test('authorized user can view the create form page', function () {
    $this->signInWithPermission('form.create');

    $response = $this->get(route('forms.create'));
    $response->assertSuccessful();
});
test('authorized user can create form', function () {
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
});
test('event is dispatched when form is created', function () {
    Event::fake();

    $this->signInWithPermission('form.create');

    $this->post(route('forms.store'), Form::factory()->make()->toArray());

    Event::assertDispatched(FormCreated::class);
});
test('unauthorized user cannot view the create form page', function () {
    $this->signIn();

    $response = $this->get(route('forms.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create form', function () {
    $this->signIn();

    $response = $this->postJson(
        route('forms.store'),
        Form::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the create form page', function () {
    $response = $this->getJson(route('forms.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create form', function () {
    $response = $this->postJson(
        route('forms.store'),
        Form::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
