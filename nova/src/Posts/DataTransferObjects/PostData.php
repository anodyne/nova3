<?php

namespace Nova\Posts\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PostData extends DataTransferObject
{
    public string $content;

    public int $post_type_id;

    public int $story_id;

    public string $title;

    public int $word_count = 0;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'content' => $request->content,
            'post_type_id' => (int) $request->post_type_id,
            'story_id' => (int) $request->story_id,
            'title' => $request->title,
            'word_count' => str_word_count(strip_tags($request->content)),
        ]);
    }
}