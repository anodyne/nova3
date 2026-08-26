<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $name, BasicStatus $status = BasicStatus::Active)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class RankNameData extends Bag
{
    public function __construct(
        public string $name,
        public BasicStatus $status = BasicStatus::Active
    ) {}

    /**
     * @return array{
     *      name: mixed,
     *      status: ?BasicStatus
     * }
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
        ];
    }
}
