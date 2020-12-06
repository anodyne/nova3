<?php

namespace Nova\Settings\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class DefaultsSettings extends DataTransferObject
{
    public string $theme = 'pulsar';

    public string $iconSet = 'fluent';
}
