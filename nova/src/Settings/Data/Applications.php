<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(bool $enabled, ?string $disabledMessage, bool $alwaysShowResults, bool $allowVoteChanging, bool $showDecisionMessage)
 */
readonly class Applications extends Bag
{
    public function __construct(
        public bool $enabled,
        public ?string $disabledMessage,
        public bool $alwaysShowResults,
        public bool $allowVoteChanging,
        public bool $showDecisionMessage
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'enabled' => $request->boolean('enabled'),
            'disabledMessage' => $request->input('disabled_message'),
            'alwaysShowResults' => $request->boolean('alwaysShowResults'),
            'allowVoteChanging' => $request->boolean('allowVoteChanging'),
            'showDecisionMessage' => $request->boolean('showDecisionMessage'),
        ];
    }
}
