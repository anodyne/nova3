<?php

declare(strict_types=1);

use Addons\TestExtension\Addon as TestExtensionAddon;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Events\AddonCreated;
use Nova\Addons\Livewire\AddonsList;
use Nova\Addons\Models\Addon;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Livewire\livewire;

uses()->group('addons');

test('can create an extension add-on', function () {
    signIn(permissions: 'addon.create');

    Event::fake();
    Storage::fake('addons');

    Artisan::shouldReceive('call')
        ->once()
        ->withAnyArgs()
        ->andReturn(0);

    $data = Addon::factory()->extension()->active()->forRequest();

    from(route('admin.addons.create'))
        ->followingRedirects()
        ->post(route('admin.addons.store'), $data->payload)
        ->assertSuccessful();

    assertDatabaseHas(Addon::class, $data->model->toArray());

    Event::assertDispatched(AddonCreated::class);

    Storage::disk('addons')->assertExists($data->model->location);
});

test('can run update extension add-on settings', function () {
    signIn(permissions: 'addon.update');

    $addon = Addon::factory()->extension()->active()->create([
        'location' => 'TestExtension',
        'settings' => new AddonSettings(settings: []),
    ]);

    livewire(AddonsList::class)
        ->callAction(TestAction::make('addonSettings')->table($addon), data: [
            'api_key' => 'new-api-key',
            'enabled' => true,
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();

    $addon->refresh();

    expect($addon->settings->settings['api_key'])->toBe('new-api-key');
    expect($addon->settings->settings['enabled'])->toBeTrue();
});

describe('extension add-on scripts', function () {
    beforeEach(function () {
        TestExtensionAddon::resetFlags();

        signIn(permissions: 'addon.update');

        $this->addon = Addon::factory()->extension()->active()->create([
            'location' => 'TestExtension',
        ]);
    });

    test('can run installer', function () {
        expect(TestExtensionAddon::$installCalled)->toBeFalse();

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($this->addon),
                TestAction::make('extensionInstall'),
            ])
            ->assertNotified();

        expect(TestExtensionAddon::$installCalled)->toBeTrue();
    });

    test('can run uninstaller', function () {
        expect(TestExtensionAddon::$uninstallCalled)->toBeFalse();

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($this->addon),
                TestAction::make('extensionUninstall'),
            ])
            ->assertNotified();

        expect(TestExtensionAddon::$uninstallCalled)->toBeTrue();
    });

    test('can run updater', function () {
        expect(TestExtensionAddon::$updateCalled)->toBeFalse();

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($this->addon),
                TestAction::make('extensionUpdate'),
            ])
            ->assertNotified();

        expect(TestExtensionAddon::$updateCalled)->toBeTrue();
    });

    test('can run migration', function () {
        Artisan::shouldReceive('call')
            ->once()
            ->with('migrate', [
                '--force' => true,
                '--path' => 'addons/TestExtension/Migrations',
            ])
            ->andReturn(0);

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($this->addon),
                TestAction::make('extensionRunMigrations'),
            ])
            ->assertNotified();
    });

    test('can run migration rollback', function () {
        Artisan::shouldReceive('call')
            ->once()
            ->with('migrate:rollback', [
                '--force' => true,
                '--path' => 'addons/TestExtension/Migrations',
            ])
            ->andReturn(0);

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($this->addon),
                TestAction::make('extensionRollbackMigrations'),
            ])
            ->assertNotified();
    });
});
