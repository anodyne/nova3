<?php

declare(strict_types=1);

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\StrayRequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nova\Foundation\Enums\CacheKeys;

use function Pest\Laravel\get;

test('authenticated requests cache the configured version checks without reaching the network', function (): void {
    signIn(permissions: 'story.view');

    get(route('admin.stories.index'))->assertSuccessful();
    get(route('admin.stories.index'))->assertSuccessful();

    expect(Cache::get(CacheKeys::LatestVersion->value)->version)->toBe('3.0.0-alpha19');
    expect(Cache::get(CacheKeys::NextVersion->value))->toBeNull();

    Http::assertSent(fn (Request $request): bool => $request->url() === config('services.anodyne.api.latest-version'));
    Http::assertSent(fn (Request $request): bool => $request->url() === config('services.anodyne.api.next-version'));
    expect(Http::recorded(fn (Request $request): bool => $request->url() === config('services.anodyne.api.latest-version')))
        ->toHaveCount(1);
    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://api.github.com/repos/anodyne/nova3/releases');
});

test('unfaked HTTP requests fail immediately in tests', function (): void {
    expect(fn () => Http::get('https://unexpected.example.test/api'))
        ->toThrow(StrayRequestException::class);
});
