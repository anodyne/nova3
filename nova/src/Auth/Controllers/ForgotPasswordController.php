<?php

declare(strict_types=1);

namespace Nova\Auth\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Nova\Auth\Responses\ForgotPasswordResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    public function showLinkRequestForm(): Responsable
    {
        return ForgotPasswordResponse::send();
    }
}
