<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Nova\Forms\Actions\DuplicateForm;
use Nova\Forms\Events\FormDuplicated;
use Nova\Forms\Models\Form;
use Nova\Foundation\Controllers\Controller;

class DuplicateFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Form $original)
    {
        $this->authorize('duplicate', $original);

        $form = DuplicateForm::run($original);

        FormDuplicated::dispatch($form, $original);

        return redirect()
            ->route('forms.edit', $form)
            ->withToast("{$original->name} has been duplicated");
    }
}
