<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Nova\Departments\Models\Department;
use Nova\Forms\Models\Form;
use Nova\Setup\Actions\Migration\MigrateDepartment;
use Nova\Setup\Actions\Migration\MigrateForm;
use Nova\Setup\Actions\Migration\MigrateLegacyUserData;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;

function newIdsTestHarness(): object
{
    return new class
    {
        use HandlesNewIds;

        /** @param Collection<int, Upgrade>|null $mappings */
        public function resolve(?int $oldId, ?Collection $mappings, string $type): ?int
        {
            return $this->getNewId($oldId, $mappings, $type);
        }
    };
}

it('migrates a typed legacy department record', function () {
    MigrateDepartment::run((object) [
        'dept_name' => 'Command',
        'dept_desc' => 'Command department',
        'dept_display' => 'y',
        'dept_order' => 1,
        'dept_id' => 42,
    ]);

    $department = Department::query()->where('name', 'Command')->firstOrFail();
    $upgrade = Upgrade::query()->where('type', 'department')->where('old_id', 42)->firstOrFail();

    expect($department->description)->toBe('Command department')
        ->and($department->status->value)->toBe('active')
        ->and($upgrade->new_id)->toBe($department->id);
});

it('creates and reuses a character form submission id', function () {
    $form = Form::factory()->createOne();

    $action = new class extends MigrateForm
    {
        public function submissionId(int $characterId, int $formId): int
        {
            return $this->getCharacterFormSubmissionId($characterId, $formId);
        }
    };

    $firstId = $action->submissionId(characterId: 100, formId: $form->id);
    $secondId = $action->submissionId(characterId: 100, formId: $form->id);

    expect($secondId)->toBe($firstId)
        ->and(DB::table('form_submissions')->where([
            'owner_type' => 'character',
            'owner_id' => 100,
        ])->count())->toBe(1);
});

it('creates and reuses a user form submission id', function () {
    $form = Form::factory()->createOne();

    $action = new class extends MigrateLegacyUserData
    {
        public function submissionId(int $userId, int $formId): int
        {
            return $this->getUserFormSubmissionId($userId, $formId);
        }
    };

    $firstId = $action->submissionId(userId: 200, formId: $form->id);
    $secondId = $action->submissionId(userId: 200, formId: $form->id);

    expect($secondId)->toBe($firstId)
        ->and(DB::table('form_submissions')->where([
            'owner_type' => 'user',
            'owner_id' => 200,
        ])->count())->toBe(1);
});

it('resolves a new id from cached upgrade mappings', function () {
    $mappings = collect([
        new Upgrade([
            'type' => 'character',
            'old_id' => 10,
            'new_id' => 110,
        ]),
    ]);

    expect(newIdsTestHarness()->resolve(10, $mappings, 'character'))->toBe(110)
        ->and(newIdsTestHarness()->resolve(20, $mappings, 'character'))->toBeNull();
});

it('resolves a new id from the database when mappings are not cached', function () {
    Upgrade::query()->create([
        'type' => 'user',
        'old_id' => 20,
        'new_id' => 220,
    ]);

    expect(newIdsTestHarness()->resolve(20, null, 'user'))->toBe(220)
        ->and(newIdsTestHarness()->resolve(20, null, 'character'))->toBeNull();
});
