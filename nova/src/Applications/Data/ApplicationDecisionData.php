<?php

declare(strict_types=1);

namespace Nova\Applications\Data;

use Bag\Bag;
use Nova\Ranks\Models\RankItem;

/**
 * @method static static from(?string $message, ?int $rank_id, array $positions)
 */
readonly class ApplicationDecisionData extends Bag
{
    public function __construct(
        public ?string $message,
        public ?int $rank_id = null,
        public array $positions = []
    ) {}

    public function rank(): ?RankItem
    {
        return RankItem::find($this->rank_id);
    }
}
