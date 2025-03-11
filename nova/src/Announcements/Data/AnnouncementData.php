<?php

declare(strict_types=1);

namespace Nova\Announcements\Data;

use Bag\Attributes\MapInputName;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Bag\Mappers\Alias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nova\Users\Models\User;

/**
 * @method static static from(string $title, ?string $category, bool $published, ?string $content)
 */
readonly class AnnouncementData extends Bag
{
    public function __construct(
        public string $title,
        public ?string $category,
        public bool $published,

        #[MapInputName(Alias::class, 'editor-content')]
        public ?string $content
    ) {}

    public function user(): User
    {
        return Auth::user();
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'published' => $request->boolean('published'),
            'content' => $request->input('editor-content'),
        ];
    }
}
