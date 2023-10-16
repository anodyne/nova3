<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Illuminate\Support\Facades\Gate;
use Nova\Forms\Actions\CreateForm;
use Nova\Forms\Data\FormData;
use Nova\Forms\Models\Form;
use Nova\Forms\Requests\CreateFormRequest;
use Nova\Forms\Responses\CreateFormResponse;
use Nova\Foundation\Controllers\Controller;

class CreateFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', Form::class);

        return CreateFormResponse::send();
    }

    public function store(CreateFormRequest $request)
    {
        $this->authorize('create', Form::class);

        $form = CreateForm::run(FormData::from($request));

        $redirect = redirect()->notify("{$form->name} was created");

        if (Gate::allows('update', $form)) {
            return $redirect->route('forms.edit', $form);
        }

        return $redirect->route('forms.index');
    }
}
