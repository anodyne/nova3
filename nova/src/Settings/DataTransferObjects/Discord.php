<?php

declare(strict_types=1);

namespace Nova\Settings\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Discord extends CastableDataTransferObject implements Arrayable
{
    public ?string $color;

    public ?string $webhook;

    public static function fromRequest(Request $request): self
    {
        return new self(
            webhook: $request->input('webhook'),
            color: $request->input('color'),
        );
    }
}
