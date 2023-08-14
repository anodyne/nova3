<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormDeleted;
use Nova\Forms\Models\Form;
beforeEach(function () {
    $this->form = Form::factory()->create();
});
test('authorized user can delete form', function () {
    $this->signInWithPermission('form.delete');

    $this->followingRedirects();

    $response = $this->delete(route('forms.destroy', $this->form));
    $response->assertSuccessful();

    $this->assertDatabaseMissing('forms', [
        'id' => $this->form->id,
    ]);
});
test('event is dispatched when role is deleted', function () {
    Event::fake();

    $this->signInWithPermission('form.delete');

    $this->delete(route('forms.destroy', $this->form));

    Event::assertDispatched(FormDeleted::class);
});
test('locked form cannot be deleted', function () {
    $this->signInWithPermission('form.delete');

    $form = Form::factory()->locked()->create();

    $response = $this->delete(route('forms.destroy', $form));
    $response->assertForbidden();

    $this->assertDatabaseHas('forms', [
        'id' => $form->id,
        'locked' => true,
    ]);
});
test('unauthorized user cannot delete form', function () {
    $this->signIn();

    $response = $this->delete(route('forms.destroy', $this->form));
    $response->assertForbidden();
});
test('unauthenticated user cannot delete form', function () {
    $response = $this->deleteJson(route('forms.destroy', $this->form));
    $response->assertUnauthorized();
});
