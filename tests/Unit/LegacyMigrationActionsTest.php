<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        public function resolve(?int $oldId, ?Collection $mappings, string $type): ?string
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
        public function submissionId(string $characterId, string $formId): string
        {
            return $this->getCharacterFormSubmissionId($characterId, $formId);
        }
    };

    $characterId = Str::uuid()->toString();
    $firstId = $action->submissionId(characterId: $characterId, formId: $form->id);
    $secondId = $action->submissionId(characterId: $characterId, formId: $form->id);

    expect($secondId)->toBe($firstId)
        ->and(DB::table('form_submissions')->where([
            'owner_type' => 'character',
            'owner_id' => $characterId,
        ])->count())->toBe(1);
});

it('creates and reuses a user form submission id', function () {
    $form = Form::factory()->createOne();

    $action = new class extends MigrateLegacyUserData
    {
        public function submissionId(string $userId, string $formId): string
        {
            return $this->getUserFormSubmissionId($userId, $formId);
        }
    };

    $userId = Str::uuid()->toString();
    $firstId = $action->submissionId(userId: $userId, formId: $form->id);
    $secondId = $action->submissionId(userId: $userId, formId: $form->id);

    expect($secondId)->toBe($firstId)
        ->and(DB::table('form_submissions')->where([
            'owner_type' => 'user',
            'owner_id' => $userId,
        ])->count())->toBe(1);
});

it('resolves a new id from cached upgrade mappings', function () {
    $newId = Str::uuid()->toString();
    $mappings = collect([
        new Upgrade([
            'type' => 'character',
            'old_id' => 10,
            'new_id' => $newId,
        ]),
    ]);

    expect(newIdsTestHarness()->resolve(10, $mappings, 'character'))->toBe($newId)
        ->and(newIdsTestHarness()->resolve(20, $mappings, 'character'))->toBeNull();
});

it('resolves a new id from the database when mappings are not cached', function () {
    $newId = Str::uuid()->toString();

    Upgrade::query()->create([
        'type' => 'user',
        'old_id' => 20,
        'new_id' => $newId,
    ]);

    expect(newIdsTestHarness()->resolve(20, null, 'user'))->toBe($newId)
        ->and(newIdsTestHarness()->resolve(20, null, 'character'))->toBeNull();
});
