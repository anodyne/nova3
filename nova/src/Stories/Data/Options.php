<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Stories\Enums\PostEditTimeframe;

/**
 * @method static static from(bool $notifiesUsers, bool $includedInPostTracking, bool $allowsMultipleAuthors, bool $allowsCharacterAuthors, bool $allowsUserAuthors, bool $showContentInTimelineView, PostEditTimeframe $editTimeframe)
 */
readonly class Options extends Bag
{
    public function __construct(
        public bool $notifiesUsers,
        public bool $includedInPostTracking,
        public bool $allowsMultipleAuthors,
        public bool $allowsCharacterAuthors,
        public bool $allowsUserAuthors,
        public bool $showContentInTimelineView,
        public PostEditTimeframe $editTimeframe,
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'notifiesUsers' => $request->boolean('options.notifiesUsers'),
            'includedInPostTracking' => $request->boolean('options.includedInPostTracking'),
            'allowsMultipleAuthors' => $request->boolean('options.allowsMultipleAuthors'),
            'allowsCharacterAuthors' => $request->boolean('options.allowsCharacterAuthors'),
            'allowsUserAuthors' => $request->boolean('options.allowsUserAuthors'),
            'showContentInTimelineView' => $request->boolean('options.showContentInTimelineView'),
            'editTimeframe' => PostEditTimeframe::tryFrom($request->input('editTimeframe', 'never')) ?? PostEditTimeframe::Never,
        ];
    }
}
