<?php

declare(strict_types=1);
use Nova\Forms\Actions\CreateForm;
use Nova\Forms\Data\FormData;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a form', function () {
    $data = FormData::from([
        'key' => 'foo',
        'name' => 'Foo',
        'description' => 'Description of foo',
        'locked' => false,
    ]);

    $form = CreateForm::run($data);

    expect($form->exists)->toBeTrue();
    expect($form->name)->toEqual('Foo');
    expect($form->key)->toEqual('foo');
    expect($form->description)->toEqual('Description of foo');
});
