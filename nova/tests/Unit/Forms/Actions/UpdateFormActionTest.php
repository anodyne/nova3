<?php

declare(strict_types=1);
use Nova\Forms\Actions\UpdateForm;
use Nova\Forms\Data\FormData;
use Nova\Forms\Models\Form;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->form = Form::factory()->create();
});
it('can update a form', function () {
    $data = FormData::from([
        'key' => 'foo',
        'name' => 'Foo',
        'description' => 'New description of foo',
        'locked' => $this->form->locked,
    ]);

    $form = UpdateForm::run($this->form, $data);

    expect($form->key)->toEqual('foo');
    expect($form->name)->toEqual('Foo');
    expect($form->description)->toEqual('New description of foo');
});
it('cannot update the key of a locked form', function () {
    $lockedForm = Form::factory()->locked()->create();

    $data = FormData::from([
        'key' => 'foo',
        'name' => 'Foo',
        'description' => 'New description of foo',
        'locked' => $lockedForm->locked,
    ]);

    $form = UpdateForm::run($lockedForm, $data);

    expect($form->key)->toEqual($lockedForm->key);
    expect($form->name)->toEqual('Foo');
    expect($form->description)->toEqual('New description of foo');
});
