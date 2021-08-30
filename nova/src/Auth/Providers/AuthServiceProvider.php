<?php

declare(strict_types=1);

namespace Nova\Auth\Providers;

use Nova\Auth\Responses\EmailVerificationResponse;
use Nova\Auth\Responses\ForgotPasswordResponse;
use Nova\Auth\Responses\LoginResponse;
use Nova\Auth\Responses\ResetPasswordResponse;
use Nova\DomainServiceProvider;

class AuthServiceProvider extends DomainServiceProvider
{
    protected array $responsables = [
        EmailVerificationResponse::class,
        ForgotPasswordResponse::class,
        LoginResponse::class,
        ResetPasswordResponse::class,
    ];
}
