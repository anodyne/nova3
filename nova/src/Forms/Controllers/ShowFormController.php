<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Illuminate\Http\Request;
use Nova\Forms\Filters\FormFilters;
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

    public function all(Request $request, FormFilters $filters)
    {
        $this->authorize('viewAny', Form::class);

        $forms = Form::query()->filter($filters);

        return ShowAllFormsResponse::sendWith([
            'forms' => $forms->paginate(),
            'search' => $request->search,
        ]);
    }

    public function show(Form $form)
    {
        $this->authorize('view', $form);

        return ShowFormResponse::sendWith([
            'form' => $form,
        ]);
    }
}
