<?php

declare(strict_types=1);

namespace Nova\Forms\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Forms\Enums\FormType;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $name, string $key, FormType $type, ?string $description, ?FormOptions $options, BasicStatus $status)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class FormData extends Bag
{
    public function __construct(
        public string $name,
        public string $key,
        public FormType $type,
        public ?string $description,
        public ?FormOptions $options,
        public BasicStatus $status
    ) {}

    /**
     * @return array{
     *      name: mixed,
     *      key: mixed,
     *      type: FormType,
     *      description: mixed,
     *      options: FormOptions,
     *      status: ?BasicStatus
     * }
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'key' => $request->input('key'),
            'type' => FormType::tryFrom($request->input('type')) ?? FormType::Basic,
            'description' => $request->input('description'),
            'options' => FormOptions::from($request),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
        ];
    }
}
