<?php

declare(strict_types=1);

namespace Nova\Applications\Data;

use Bag\Bag;
use Nova\Ranks\Models\RankItem;

/**
 * @method static static from(?string $message, ?string $rank_id, list<string> $positions)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class ApplicationDecisionData extends Bag
{
    /** @param list<string> $positions */
    public function __construct(
        public ?string $message,
        public ?string $rank_id = null,
        public array $positions = []
    ) {}

    public function rank(): ?RankItem
    {
        return RankItem::find($this->rank_id);
    }
}
