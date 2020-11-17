<?php

namespace Nova\PostTypes\Values;

use Illuminate\Contracts\Support\Arrayable;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Options extends CastableDataTransferObject implements Arrayable
{
    public bool $notifyUsers;

    public bool $notifyDiscord;

    public bool $includeInPostCounts;

    public bool $multipleAuthors;

    public static function fromArray(array $array): self
    {
        return new self([
            'notifyUsers' => (bool) data_get($array, 'notifyUsers'),
            'notifyDiscord' => (bool) data_get($array, 'notifyDiscord'),
            'includeInPostCounts' => (bool) data_get($array, 'includeInPostCounts'),
            'multipleAuthors' => (bool) data_get($array, 'multipleAuthors'),
        ]);
    }
}
