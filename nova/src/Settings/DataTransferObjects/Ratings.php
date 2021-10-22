<?php

declare(strict_types=1);

namespace Nova\Settings\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Ratings extends CastableDataTransferObject implements Arrayable
{
    public string $theme = 'pulsar';

    public string $iconSet = 'fluent';

    public static function fromRequest(Request $request): self
    {
        return new self(
            iconSet: $request->input('icon-set', 'fluent'),
            theme: $request->input('theme', 'pulsar')
        );
    }
}
