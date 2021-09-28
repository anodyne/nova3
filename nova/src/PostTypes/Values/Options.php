<?php

declare(strict_types=1);

namespace Nova\PostTypes\Values;

use Illuminate\Contracts\Support\Arrayable;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Options extends CastableDataTransferObject implements Arrayable
{
    public bool $notifyUsers;

    public bool $notifyDiscord;

    public bool $includeInPostTracking;

    public bool $multipleAuthors;

    public static function fromArray(array $array): self
    {
        return new self(
            notifyUsers: (bool) data_get($array, 'notifyUsers'),
            notifyDiscord: (bool) data_get($array, 'notifyDiscord'),
            includeInPostTracking: (bool) data_get($array, 'includeInPostTracking'),
            multipleAuthors: (bool) data_get($array, 'multipleAuthors'),
        );
    }
}
