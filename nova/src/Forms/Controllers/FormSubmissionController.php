<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Forms\Responses\CreateFormSubmissionResponse;
use Nova\Forms\Responses\EditFormSubmissionResponse;
use Nova\Forms\Responses\ListFormSubmissionsResponse;
use Nova\Forms\Responses\ShowFormSubmissionResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Responses\Responsable;

class FormSubmissionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(FormSubmission::class, 'submission');
    }

    public function index(): Responsable
    {
        return ListFormSubmissionsResponse::send();
    }

    public function show(FormSubmission $submission): Responsable
    {
        return ShowFormSubmissionResponse::sendWith([
            'submission' => $submission->loadMissing('form', 'responses.field'),
        ]);
    }

    public function create(?Form $form = null): Responsable
    {
        abort_if($form && $form->status === BasicStatus::Inactive, 404);

        return CreateFormSubmissionResponse::sendWith([
            'form' => $form,
            'forms' => Form::query()->active()->submissible()->get(),
        ]);
    }

    public function edit(FormSubmission $submission): Responsable
    {
        return EditFormSubmissionResponse::sendWith([
            'submission' => $submission->load('form'),
        ]);
    }
}
