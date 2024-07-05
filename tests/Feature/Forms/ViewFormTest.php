<?php

declare(strict_types=1);

use Nova\Forms\Models\Form;

use function Pest\Laravel\get;

uses()->group('forms');

beforeEach(function () {
    $this->form = Form::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'form.view');
    });

    test('can view the view form page', function () {
        get(route('forms.show', $this->form))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view form page', function () {
        get(route('forms.show', $this->form))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view form page', function () {
        get(route('forms.show', $this->form))
            ->assertRedirectToRoute('login');
    });
});
