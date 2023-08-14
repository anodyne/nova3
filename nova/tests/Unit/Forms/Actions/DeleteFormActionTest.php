<?php

declare(strict_types=1);
use Nova\Forms\Actions\DeleteForm;
use Nova\Forms\Models\Form;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->form = Form::factory()->create();
});
it('deletes a form', function () {
    $form = DeleteForm::run($this->form);

    expect($form->exists)->toBeFalse();
});
