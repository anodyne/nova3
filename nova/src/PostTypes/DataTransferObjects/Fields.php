<?php

namespace Nova\PostTypes\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class Fields extends DataTransferObject
{
    public bool $title;

    public bool $time;

    public bool $location;

    public bool $content;

    public static function fromArray(array $array): self
    {
        return new self([
            'title' => (bool) data_get($array, 'title'),
            'time' => (bool) data_get($array, 'time'),
            'location' => (bool) data_get($array, 'location'),
            'content' => (bool) data_get($array, 'content'),
        ]);
    }
}
