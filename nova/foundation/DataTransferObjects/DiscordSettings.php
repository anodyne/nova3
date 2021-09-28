<?php

declare(strict_types=1);

namespace Nova\Foundation\DataTransferObjects;

use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class DiscordSettings extends CastableDataTransferObject
{
    public ?string $webhook;

    public ?string $color;
}
