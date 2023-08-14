<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormDuplicated;
use Nova\Forms\Models\Form;
beforeEach(function () {
    $this->form = Form::factory()->create([
        'key' => 'foo',
        'name' => 'Foo',
    ]);
});
test('authorized user can duplicate form', function () {
    $this->signInWithPermission(['form.create', 'form.update']);

    $this->followingRedirects();

    $response = $this->post(route('forms.duplicate', $this->form));
    $response->assertSuccessful();

    $this->assertDatabaseHas('forms', [
        'name' => "Copy of {$this->form->name}",
    ]);
});
test('event is dispatched when form is duplicated', function () {
    Event::fake();

    $this->signInWithPermission(['form.create', 'form.update']);

    $this->post(route('forms.duplicate', $this->form));

    Event::assertDispatched(FormDuplicated::class);
});
test('locked form cannot be duplicated', function () {
    $form = Form::factory()->locked()->create();

    $this->signInWithPermission(['form.create', 'form.update']);

    $formCount = Form::count();

    $response = $this->postJson(route('forms.duplicate', $form));
    $response->assertForbidden();

    expect(Form::count())->toEqual($formCount);
});
test('unauthorized user cannot duplicate form', function () {
    $this->signIn();

    $response = $this->post(route('forms.duplicate', $this->form));
    $response->assertForbidden();
});
test('unauthenticated user cannot duplicate form', function () {
    $response = $this->postJson(route('forms.duplicate', $this->form));
    $response->assertUnauthorized();
});
