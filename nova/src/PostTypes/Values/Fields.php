<?php

declare(strict_types=1);

namespace Nova\PostTypes\Values;

use Illuminate\Contracts\Support\Arrayable;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Fields extends CastableDataTransferObject implements Arrayable
{
    public Field $title;

    public Field $day;

    public Field $time;

    public Field $location;

    public Field $content;

    public Field $rating;

    public Field $summary;

    public static function fromArray(array $array): self
    {
        return new self([
            'title' => Field::fromArray(data_get($array, 'title', [])),
            'day' => Field::fromArray(data_get($array, 'day', [])),
            'time' => Field::fromArray(data_get($array, 'time', [])),
            'location' => Field::fromArray(data_get($array, 'location', [])),
            'content' => Field::fromArray(data_get($array, 'content', [])),
            'rating' => Field::fromArray(data_get($array, 'rating', [])),
            'summary' => Field::fromArray(data_get($array, 'summary', [])),
        ]);
    }
}
