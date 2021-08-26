<?php

declare(strict_types=1);

namespace Nova\Settings\Values;

use Illuminate\Contracts\Support\Arrayable;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Defaults extends CastableDataTransferObject implements Arrayable
{
    public string $theme = 'pulsar';

    public string $iconSet = 'fluent';
}
