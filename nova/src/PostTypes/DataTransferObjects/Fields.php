<?php

namespace Nova\PostTypes\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\DataTransferObject\DataTransferObject;

class Fields extends DataTransferObject implements Arrayable
{
    public Field $title;

    public Field $day;

    public Field $time;

    public Field $location;

    public Field $content;

    public Field $rating;

    public static function fromArray(array $array): self
    {
        return new self([
            'title' => Field::fromArray(data_get($array, 'title', [])),
            'day' => Field::fromArray(data_get($array, 'day', [])),
            'time' => Field::fromArray(data_get($array, 'time', [])),
            'location' => Field::fromArray(data_get($array, 'location', [])),
            'content' => Field::fromArray(data_get($array, 'content', [])),
            'rating' => Field::fromArray(data_get($array, 'rating', [])),
        ]);
    }
}
