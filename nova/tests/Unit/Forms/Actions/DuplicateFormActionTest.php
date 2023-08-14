<?php

declare(strict_types=1);
use Nova\Forms\Actions\DuplicateForm;
use Nova\Forms\Models\Form;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->form = Form::factory()->create();
});
it('duplicates a form', function () {
    $form = DuplicateForm::run($this->form);

    expect($form->name)->toEqual("Copy of {$this->form->name}");
});
