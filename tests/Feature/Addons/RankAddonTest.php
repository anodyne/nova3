<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Addons\Events\AddonCreated;
use Nova\Addons\Livewire\AddonsList;
use Nova\Addons\Models\Addon;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Livewire\livewire;

uses()->group('addons');

test('can create a rank add-on', function () {
    signIn(permissions: 'addon.create');

    Event::fake();
    Storage::fake('addons');
    Storage::fake('ranks');

    $data = Addon::factory()->rank()->active()->forRequest();

    from(route('admin.addons.create'))
        ->followingRedirects()
        ->post(route('admin.addons.store'), $data->payload)
        ->assertSuccessful();

    assertDatabaseHas(Addon::class, $data->model->toArray());

    Event::assertDispatched(AddonCreated::class);

    Storage::disk('addons')->assertExists($data->model->location);
});

describe('rank add-on scripts', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.update');

        app()->useAddonPath(base_path('tests/fixtures/addons'));
    });

    test('can run installer', function () {
        Storage::fake('ranks');

        $addon = Addon::factory()->rank()->active()->create([
            'location' => 'TestRank',
        ]);

        $disk = Storage::disk('ranks');

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($addon),
                TestAction::make('rankSetInstall'),
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
    });

    test('can run uninstaller', function () {
        Storage::fake('ranks');

        $addon = Addon::factory()->rank()->active()->create([
            'location' => 'TestRank',
        ]);

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
                TestAction::make('rankSetUninstall'),
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
    });

    test('can run image appender', function () {
        Storage::fake('ranks');

        $addon = Addon::factory()->rank()->active()->create([
            'location' => 'TestRank',
        ]);

        $disk = Storage::disk('ranks');

        $disk->put('base/base1.png', 'fake content');
        $disk->put('base/base2.png', 'fake content');
        $disk->put('overlay/naval/overlay1.png', 'fake content');
        $disk->put('overlay/marine/overlay2.png', 'fake content');

        $disk->assertExists('base/base1.png');
        $disk->assertExists('base/base2.png');
        $disk->assertExists('overlay/naval/overlay1.png');
        $disk->assertExists('overlay/marine/overlay2.png');

        $disk->assertMissing('base/red.png');
        $disk->assertMissing('base/yellow.png');
        $disk->assertMissing('base/teal.png');
        $disk->assertMissing('overlay/naval/o6.png');
        $disk->assertMissing('overlay/naval/o5.png');
        $disk->assertMissing('overlay/naval/o4.png');
        $disk->assertMissing('overlay/marine/o6.png');
        $disk->assertMissing('overlay/marine/o5.png');
        $disk->assertMissing('overlay/marine/o4.png');

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($addon),
                TestAction::make('rankSetAppend'),
            ])
            ->assertNotified();

        $disk->assertExists('base/base1.png');
        $disk->assertExists('base/base2.png');
        $disk->assertExists('base/red.png');
        $disk->assertExists('base/yellow.png');
        $disk->assertExists('base/teal.png');

        $disk->assertExists('overlay/naval/overlay1.png');
        $disk->assertExists('overlay/naval/o6.png');
        $disk->assertExists('overlay/naval/o5.png');
        $disk->assertExists('overlay/naval/o4.png');

        $disk->assertExists('overlay/marine/overlay2.png');
        $disk->assertExists('overlay/marine/o6.png');
        $disk->assertExists('overlay/marine/o5.png');
        $disk->assertExists('overlay/marine/o4.png');
    });

    test('can run image replacer', function () {
        Storage::fake('ranks');

        $addon = Addon::factory()->rank()->active()->create([
            'location' => 'TestRank',
        ]);

        $ranksDisk = Storage::disk('ranks');

        $ranksDisk->put('base/pink.png', 'original pink content');
        $ranksDisk->put('base/red.png', 'original red content');
        $ranksDisk->put('base/teal.png', 'original teal content');
        $ranksDisk->put('base/yellow.png', 'original yellow content');

        $ranksDisk->put('overlay/naval/o6.png', 'original naval o6 content');
        $ranksDisk->put('overlay/naval/o5.png', 'original naval o5 content');
        $ranksDisk->put('overlay/naval/o4.png', 'original naval o4 content');
        $ranksDisk->put('overlay/naval/o3.png', 'original naval o3 content');

        $ranksDisk->put('overlay/marine/o6.png', 'original marine o6 content');
        $ranksDisk->put('overlay/marine/o5.png', 'original marine o5 content');
        $ranksDisk->put('overlay/marine/o4.png', 'original marine o4 content');
        $ranksDisk->put('overlay/marine/o3.png', 'original marine o3 content');

        expect($ranksDisk->get('base/pink.png'))->toBe('original pink content');
        expect($ranksDisk->get('base/red.png'))->toBe('original red content');
        expect($ranksDisk->get('base/teal.png'))->toBe('original teal content');
        expect($ranksDisk->get('base/yellow.png'))->toBe('original yellow content');

        expect($ranksDisk->get('overlay/naval/o6.png'))->toBe('original naval o6 content');
        expect($ranksDisk->get('overlay/naval/o5.png'))->toBe('original naval o5 content');
        expect($ranksDisk->get('overlay/naval/o4.png'))->toBe('original naval o4 content');
        expect($ranksDisk->get('overlay/naval/o3.png'))->toBe('original naval o3 content');

        expect($ranksDisk->get('overlay/marine/o6.png'))->toBe('original marine o6 content');
        expect($ranksDisk->get('overlay/marine/o5.png'))->toBe('original marine o5 content');
        expect($ranksDisk->get('overlay/marine/o4.png'))->toBe('original marine o4 content');
        expect($ranksDisk->get('overlay/marine/o3.png'))->toBe('original marine o3 content');

        livewire(AddonsList::class)
            ->callAction([
                TestAction::make('openActionsPanel')->table($addon),
                TestAction::make('rankSetReplace'),
            ])
            ->assertNotified();

        expect($ranksDisk->get('base/pink.png'))->toBe('original pink content');
        expect($ranksDisk->get('base/red.png'))->not()->toBe('original red content');
        expect($ranksDisk->get('base/teal.png'))->not()->toBe('original teal content');
        expect($ranksDisk->get('base/yellow.png'))->not()->toBe('original yellow content');

        expect($ranksDisk->get('overlay/naval/o6.png'))->not()->toBe('original naval o6 content');
        expect($ranksDisk->get('overlay/naval/o5.png'))->not()->toBe('original naval o5 content');
        expect($ranksDisk->get('overlay/naval/o4.png'))->not()->toBe('original naval o4 content');
        expect($ranksDisk->get('overlay/naval/o3.png'))->toBe('original naval o3 content');

        expect($ranksDisk->get('overlay/marine/o6.png'))->not()->toBe('original marine o6 content');
        expect($ranksDisk->get('overlay/marine/o5.png'))->not()->toBe('original marine o5 content');
        expect($ranksDisk->get('overlay/marine/o4.png'))->not()->toBe('original marine o4 content');
        expect($ranksDisk->get('overlay/marine/o3.png'))->toBe('original marine o3 content');
    });
});
