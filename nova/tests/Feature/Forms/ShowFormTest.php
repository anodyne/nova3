<?php

declare(strict_types=1);
use Nova\Forms\Models\Form;
beforeEach(function () {
    $this->form = Form::factory()->create();
});
test('authorized user can view a form', function () {
    $this->signInWithPermission('form.view');

    $response = $this->get(route('forms.show', $this->form));
    $response->assertSuccessful();
    $response->assertViewHas('form', $this->form);
});
test('unauthorized user cannot view a form', function () {
    $this->signIn();

    $response = $this->get(route('forms.show', $this->form));
    $response->assertForbidden();
});
test('unauthenticated user cannot view a form', function () {
    $response = $this->getJson(route('forms.show', $this->form));
    $response->assertUnauthorized();
});
