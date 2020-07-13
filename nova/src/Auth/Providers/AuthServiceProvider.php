<?php

namespace Nova\Auth\Providers;

use Nova\DomainServiceProvider;
use Nova\Auth\Responses\LoginResponse;
use Nova\Auth\Responses\ResetPasswordResponse;
use Nova\Auth\Responses\ForgotPasswordResponse;
use Nova\Auth\Responses\EmailVerificationResponse;

class AuthServiceProvider extends DomainServiceProvider
{
    protected $responsables = [
        EmailVerificationResponse::class,
        ForgotPasswordResponse::class,
        LoginResponse::class,
        ResetPasswordResponse::class,
    ];
}
