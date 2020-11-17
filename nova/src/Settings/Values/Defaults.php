<?php

namespace Nova\Settings\Values;

use Illuminate\Contracts\Support\Arrayable;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Defaults extends CastableDataTransferObject implements Arrayable
{
    public string $theme;

    public string $iconSet;
}
