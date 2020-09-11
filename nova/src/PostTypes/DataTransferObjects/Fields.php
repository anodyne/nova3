<?php

namespace Nova\PostTypes\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\DataTransferObject\DataTransferObject;

class Fields extends DataTransferObject implements Arrayable
{
    public bool $title;

    public bool $day;

    public bool $time;

    public bool $location;

    public bool $content;

    public static function fromArray(array $array): self
    {
        return new self([
            'title' => (bool) data_get($array, 'title'),
            'day' => (bool) data_get($array, 'day'),
            'time' => (bool) data_get($array, 'time'),
            'location' => (bool) data_get($array, 'location'),
            'content' => (bool) data_get($array, 'content'),
        ]);
    }
}
