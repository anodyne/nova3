<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Illuminate\Http\Request;
use Nova\Forms\Actions\DeleteForm;
use Nova\Forms\Models\Form;
use Nova\Forms\Responses\DeleteFormResponse;
use Nova\Foundation\Controllers\Controller;

class DeleteFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $form = Form::findOrFail($request->id);

        return DeleteFormResponse::sendWith([
            'form' => $form,
        ]);
    }

    public function destroy(Form $form)
    {
        $this->authorize('delete', $form);

        DeleteForm::run($form);

        return redirect()
            ->route('forms.index')
            ->notify("{$form->name} was deleted");
    }
}
