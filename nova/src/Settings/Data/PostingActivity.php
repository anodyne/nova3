<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class PostingActivity extends Data implements Arrayable
{
    public function __construct(
        public string $postsStrategy,
        public string $trackingStrategy,
        public int $requiredActivity,
        public int $wordCountPostConversion,
        public string $wordCountStrategy,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            postsStrategy: $request->input('posts-strategy', 'author'),
            requiredActivity: (int) $request->input('required-activity', 0),
            trackingStrategy: $request->input('tracking-strategy', 'words'),
            wordCountPostConversion: (int) $request->input('word-count-post-conversion', 500),
            wordCountStrategy: $request->input('word-count-strategy', 'average')
        );
    }
}
