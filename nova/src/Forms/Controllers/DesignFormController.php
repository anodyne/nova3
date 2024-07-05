<?php

declare(strict_types=1);

namespace Nova\Forms\Controllers;

use Illuminate\Http\Request;
use Nova\Forms\Models\Form;
use Nova\Forms\Responses\DesignFormResponse;
use Nova\Foundation\Controllers\Controller;

class DesignFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, Form $form)
    {
        return DesignFormResponse::sendWith([
            'form' => $form,
        ]);
    }
}
