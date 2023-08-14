<?php

declare(strict_types=1);
use Nova\Forms\Models\Form;
test('authorized user with create permission can view manage forms page', function () {
    $this->signInWithPermission('form.create');

    $response = $this->get(route('forms.index'));
    $response->assertSuccessful();
});
test('authorized user with update permission can view manage forms page', function () {
    $this->signInWithPermission('form.update');

    $response = $this->get(route('forms.index'));
    $response->assertSuccessful();
});
test('authorized user with delete permission can view manage forms page', function () {
    $this->signInWithPermission('form.delete');

    $response = $this->get(route('forms.index'));
    $response->assertSuccessful();
});
test('authorized user with view permission can view manage forms page', function () {
    $this->signInWithPermission('form.view');

    $response = $this->get(route('forms.index'));
    $response->assertSuccessful();
});
test('forms can be filtered by name', function () {
    $this->signInWithPermission('form.create');

    Form::factory()->create([
        'name' => 'barbaz',
    ]);

    $response = $this->get(route('forms.index'));
    $response->assertSuccessful();

    expect($response['forms']->total())->toEqual(Form::count());

    $response = $this->get(route('forms.index', 'search=barbaz'));
    $response->assertSuccessful();

    expect($response['forms'])->toHaveCount(1);
});
test('forms can be filtered by key', function () {
    $this->signInWithPermission('form.create');

    Form::factory()->create([
        'key' => 'foobar',
    ]);

    $response = $this->get(route('forms.index'));
    $response->assertSuccessful();

    expect($response['forms']->total())->toEqual(Form::count());

    $response = $this->get(route('forms.index', 'search=foobar'));
    $response->assertSuccessful();

    expect($response['forms'])->toHaveCount(1);
});
test('unauthorized user cannot view manage forms page', function () {
    $this->signIn();

    $response = $this->get(route('forms.index'));
    $response->assertForbidden();
});
test('unauthenticated user cannot view manage forms page', function () {
    $response = $this->getJson(route('forms.index'));
    $response->assertUnauthorized();
});
