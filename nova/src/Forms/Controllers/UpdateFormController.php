<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Nova\Forms\Actions\UpdateForm;
use Nova\Forms\Data\FormData;
use Nova\Forms\Models\Form;
use Nova\Forms\Requests\UpdateFormRequest;
use Nova\Forms\Responses\UpdateFormResponse;
use Nova\Foundation\Controllers\Controller;

class UpdateFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(Form $form)
    {
        $this->authorize('update', $form);

        return UpdateFormResponse::sendWith([
            'form' => $form,
        ]);
    }

    public function update(UpdateFormRequest $request, Form $form)
    {
        $this->authorize('update', $form);

        $form = UpdateForm::run($form, FormData::from($request));

        return back()->withToast("{$form->name} was updated");
    }
}
