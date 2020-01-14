<?php

namespace Nova\Auth\Http\Controllers;

use Nova\Foundation\Http\Controllers\Controller;
use Nova\Auth\Http\Responses\ForgotPasswordResponse;
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
