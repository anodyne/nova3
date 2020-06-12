<?php

namespace Nova\Settings\Providers;

use Nova\DomainServiceProvider;
use Nova\Settings\Http\Responses\SettingsResponse;

class SettingsServiceProvider extends DomainServiceProvider
{
    protected $responsables = [
        SettingsResponse::class,
    ];
}
