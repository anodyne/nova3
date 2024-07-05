<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Illuminate\Http\Request;
use Nova\Forms\Models\Form;
use Nova\Forms\Responses\PreviewFormResponse;
use Nova\Foundation\Controllers\Controller;

class PreviewFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, Form $form, ?string $theme = 'public')
    {
        return PreviewFormResponse::sendWith([
            'form' => $form,
            'theme' => $theme,
        ]);
    }
}
