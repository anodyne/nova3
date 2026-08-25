<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Cache;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\NovaManager;

test('service and path helpers return their expected types', function (): void {
    expect(gate())->toBeInstanceOf(Gate::class)
        ->and(pipe('value'))->toBeInstanceOf(Pipeline::class)
        ->and(nova())->toBeInstanceOf(NovaManager::class)
        ->and(nova_path('config'))->toBeString()
        ->and(theme_path('views'))->toBeString()
        ->and(addon_path('Example'))->toBeString()
        ->and(rank_path('Example'))->toBeString();
});

test('string helpers parse placeholders and class names', function (): void {
    expect(get_class_name('Nova\\Users\\Models\\User'))->toBe('User')
        ->and(parse('Hello, {name}', ['name' => 'Nova']))->toBe('Hello, Nova')
        ->and(parse('Hello, {name}', [], errPlaceholder: 'unknown'))->toBe('Hello, unknown')
        ->and(parse('@{name} and @@{name}', ['name' => 'Nova']))->toBe('{name} and @Nova');
});

test('add-on and external content helpers handle unavailable values', function (): void {
    Cache::put(CacheKeys::ExternalContent->value, ['nested' => ['value']]);

    expect(addon('MissingAddon'))->toBeNull()
        ->and(external_content('nested'))->toBeNull();
});
