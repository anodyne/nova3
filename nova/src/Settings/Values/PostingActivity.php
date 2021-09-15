<?php

declare(strict_types=1);

namespace Nova\Settings\Values;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class PostingActivity extends CastableDataTransferObject implements Arrayable
{
    public string $postsStrategy;

    public string $trackingStrategy;

    public string $requiredActivity;

    public ?string $wordCountPostConversion;

    public string $wordCountStrategy;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'postsStrategy' => $request->input('posts-strategy', 'author'),
            'requiredActivity' => $request->input('required-activity', '0'),
            'trackingStrategy' => $request->input('tracking-strategy', 'words'),
            'wordCountPostConversion' => $request->input('word-count-post-conversion', '500'),
            'wordCountStrategy' => $request->input('word-count-strategy', 'average'),
        ]);
    }
}
