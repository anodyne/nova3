<?php

declare(strict_types=1);

namespace Nova\Notes\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nova\Users\Models\User;

/**
 * @method static static from(string $title, ?string $content)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class NoteData extends Bag
{
    public function __construct(
        public string $title,
        public ?string $content
    ) {}

    public function user(): User
    {
        return Auth::user();
    }

    /**
     * @return array{
     *      title: mixed,
     *      content: mixed
     * }
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ];
    }
}
