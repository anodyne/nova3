<?php

declare(strict_types=1);

use Addons\TestGenre\Addon as TestGenreAddon;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Addons\Events\AddonCreated;
use Nova\Addons\Livewire\AddonsList;
use Nova\Addons\Models\Addon;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Livewire\livewire;

uses()->group('addons');

beforeEach(function () {
    signIn(permissions: 'addon.create');
});

test('can create a genre add-on', function () {
    Event::fake();
    Storage::fake('addons');
    Storage::fake('ranks');

    $data = Addon::factory()->genre()->active()->forRequest();

    from(route('admin.addons.create'))
        ->followingRedirects()
        ->post(route('admin.addons.store'), $data->payload)
        ->assertSuccessful();

    assertDatabaseHas(Addon::class, $data->model->toArray());

    Event::assertDispatched(AddonCreated::class);

    Storage::disk('addons')->assertExists($data->model->location);
});

describe('genre add-on scripts', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.update');

        app()->useAddonPath(base_path('tests/fixtures/addons'));
    });

    test('can run installer', function () {
        Storage::fake('ranks');

        $addon = Addon::factory()->genre()->inactive()->create([
            'location' => 'TestGenre',
        ]);

        $oldAddon = Addon::factory()->genre()->active()->create();

        $disk = Storage::disk('ranks');

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($addon),
                TestAction::make('genreInstall'),
            ])
            ->assertNotified();

        $disk->assertExists('base/red.png');
        $disk->assertExists('base/teal.png');
        $disk->assertExists('base/yellow.png');
        $disk->assertExists('overlay/naval/o6.png');
        $disk->assertExists('overlay/naval/o5.png');
        $disk->assertExists('overlay/naval/o4.png');
        $disk->assertExists('overlay/marine/o6.png');
        $disk->assertExists('overlay/marine/o5.png');
        $disk->assertExists('overlay/marine/o4.png');

        expect(RankGroup::count())->toBeGreaterThan(0);
        expect(RankName::count())->toBeGreaterThan(0);
        expect(RankItem::count())->toBeGreaterThan(0);
        expect(Department::count())->toBeGreaterThan(0);
        expect(Position::count())->toBeGreaterThan(0);

        assertDatabaseHas(Addon::class, [
            'id' => $oldAddon->id,
            'status' => 'inactive',
        ]);

        assertDatabaseHas(Addon::class, [
            'id' => $addon->id,
            'status' => 'active',
        ]);
    });

    test('can run uninstaller', function () {
        Storage::fake('ranks');

        $addon = Addon::factory()->genre()->active()->create([
            'location' => 'TestGenre',
        ]);

        RankItem::factory()->active()->create();
        Position::factory()->create();

        assertDatabaseCount('rank_groups', 1);
        assertDatabaseCount('rank_names', 1);
        assertDatabaseCount('rank_items', 1);
        assertDatabaseCount('positions', 1);
        assertDatabaseCount('departments', 1);

        $disk = Storage::disk('ranks');

        $disk->put('base/base1.png', 'fake content');
        $disk->put('base/base2.png', 'fake content');
        $disk->put('overlay/naval/overlay1.png', 'fake content');
        $disk->put('overlay/marine/overlay2.png', 'fake content');

        $disk->assertExists('base/base1.png');
        $disk->assertExists('base/base2.png');
        $disk->assertExists('overlay/naval/overlay1.png');
        $disk->assertExists('overlay/marine/overlay2.png');

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($addon),
                TestAction::make('genreUninstall'),
            ])
            ->assertNotified();

        $disk->assertMissing('base/base1.png');
        $disk->assertMissing('base/base2.png');
        $disk->assertMissing('overlay/naval/overlay1.png');
        $disk->assertMissing('overlay/marine/overlay2.png');

        $disk->assertMissing('base');
        $disk->assertMissing('overlay');

        expect($disk->allFiles())->toBeEmpty();
        expect($disk->allDirectories())->toBeEmpty();

        assertDatabaseEmpty('rank_groups');
        assertDatabaseEmpty('rank_names');
        assertDatabaseEmpty('rank_items');
        assertDatabaseEmpty('positions');
        assertDatabaseEmpty('departments');
    });

    test('can run updater', function () {
        Storage::fake('ranks');

        $addon = Addon::factory()->genre()->active()->create([
            'location' => 'TestGenre',
        ]);

        expect(TestGenreAddon::$updateCalled)->toBeFalse();

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($addon),
                TestAction::make('genreUpdate'),
            ])
            ->assertNotified();

        expect(TestGenreAddon::$updateCalled)->toBeTrue();
    });
});
