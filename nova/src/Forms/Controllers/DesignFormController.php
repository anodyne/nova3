<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Nova\Forms\Models\Form;
use Nova\Forms\Responses\DesignFormResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class DesignFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Form $form): Responsable
    {
        $this->authorize('design', $form);

        return DesignFormResponse::sendWith([
            'form' => $form,
        ]);
    }
}
