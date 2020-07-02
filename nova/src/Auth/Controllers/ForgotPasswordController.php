<?php

namespace Nova\Auth\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Auth\Responses\ForgotPasswordResponse;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return app(ForgotPasswordResponse::class);
    }
}
