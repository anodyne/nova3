<?php

declare(strict_types=1);

namespace Nova\Settings\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class SettingInfo extends DataTransferObject
{
    public string $dto;

    public string $response;
}
