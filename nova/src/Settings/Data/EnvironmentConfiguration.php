<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\MapInputName;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Bag\Mappers\SnakeCase;
use Illuminate\Http\Request;
use Nova\Settings\Enums\ServerEnvironment;

/**
 * @method static static from(?string $url, ?string $environment, ?int $debugMode)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[MapInputName(SnakeCase::class)]
readonly class EnvironmentConfiguration extends Bag
{
    public function __construct(
        public ?string $url,
        public ServerEnvironment $environment,
        public bool $debugMode
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'url' => $request->input('url'),
            'environment' => ServerEnvironment::tryFrom($request->input('environment')) ?? ServerEnvironment::Production,
            'debugMode' => $request->boolean('debug_mode', false),
        ];
    }
}
