<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Nova\Forms\Actions\CreateForm;
use Nova\Forms\Actions\UpdateForm;
use Nova\Forms\Models\Form;
use Nova\Forms\Requests\StoreFormRequest;
use Nova\Forms\Requests\UpdateFormRequest;
use Nova\Forms\Responses\CreateFormResponse;
use Nova\Forms\Responses\EditFormResponse;
use Nova\Forms\Responses\ListFormsResponse;
use Nova\Forms\Responses\ShowFormResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class FormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Form::class);
    }

    public function index(): Responsable
    {
        return ListFormsResponse::send();
    }

    public function show(Form $form): Responsable
    {
        return ShowFormResponse::sendWith([
            'form' => $form,
        ]);
    }

    public function create(): Responsable
    {
        return CreateFormResponse::send();
    }

    public function store(StoreFormRequest $request)
    {
        $form = CreateForm::run($request->getFormData());

        return to_route('admin.forms.index')
            ->notify("{$form->name} form was created");
    }

    public function edit(Form $form): Responsable
    {
        $fields = collect($form->published_fields ?? [])
            ->flatMap(fn ($field): array => [
                data_get($field, 'data.attrs.id') => data_get($field, 'data.details.label'),
            ]);

        return EditFormResponse::sendWith([
            'form' => $form,
            'fields' => $fields,
        ]);
    }

    public function update(UpdateFormRequest $request, Form $form)
    {
        $form = UpdateForm::run($form, $request->getFormData());

        return back()->notify("{$form->name} form was updated");
    }
}
