<?php

namespace Nova\Settings\Providers;

use Nova\DomainServiceProvider;
use Nova\Settings\Responses\SettingsResponse;

class SettingsServiceProvider extends DomainServiceProvider
{
    protected $responsables = [
        SettingsResponse::class,
    ];
}
