<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Nova\Forms\Models\Form;
use Nova\Forms\Responses\ShowAllFormsResponse;
use Nova\Forms\Responses\ShowFormResponse;
use Nova\Foundation\Controllers\Controller;

class ShowFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all()
    {
        $this->authorize('viewAny', Form::class);

        return ShowAllFormsResponse::send();
    }

    public function show(Form $form)
    {
        $this->authorize('view', $form);

        return ShowFormResponse::sendWith([
            'form' => $form,
        ]);
    }
}
