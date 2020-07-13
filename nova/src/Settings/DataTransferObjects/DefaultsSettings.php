<?php

namespace Nova\Settings\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class DefaultsSettings extends DataTransferObject
{
    /**
     * @var  string
     */
    public $theme;

    /**
     * @var  string
     */
    public $iconSet;
}
