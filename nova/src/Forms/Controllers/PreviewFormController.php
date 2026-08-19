<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Nova\Forms\Models\Form;
use Nova\Forms\Responses\PreviewFormResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class PreviewFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Form $form, ?string $theme = 'public'): Responsable
    {
        return PreviewFormResponse::sendWith([
            'form' => $form,
            'theme' => $theme,
        ]);
    }
}
