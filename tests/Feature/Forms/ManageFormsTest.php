<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Livewire\FormsList;
use Nova\Forms\Models\Form;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('forms');

beforeEach(function () {
    $this->forms = Form::factory()->count(5)->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'form.create'));

    test('can view the list forms page', function () {
        get(route('admin.forms.index'))->assertSuccessful();

        livewire(FormsList::class)
            ->assertCanSeeTableRecords($this->forms);
    });

    test('can search forms by name', function () {
        $form = Form::factory()->create(['name' => 'A test form']);

        $forms = $this->forms->push($form);

        livewire(FormsList::class)
            ->searchTable('banana')
            ->assertCanNotSeeTableRecords($forms)
            ->searchTable('test form')
            ->assertCanSeeTableRecords([$form]);
    });

    test('can filter forms by type', function () {
        livewire(FormsList::class)
            ->filterTable('type', FormType::Basic->value)
            ->assertCanSeeTableRecords($this->forms->where('type', FormType::Basic))
            ->assertCanNotSeeTableRecords($this->forms->where('type', '!=', FormType::Basic))
            ->filterTable('type', FormType::Advanced->value)
            ->assertCanSeeTableRecords($this->forms->where('type', FormType::Advanced))
            ->assertCanNotSeeTableRecords($this->forms->where('type', '!=', FormType::Advanced));
    });

    test('can filter forms by status', function () {
        livewire(FormsList::class)
            ->filterTable('status', BasicStatus::Active->value)
            ->assertCanSeeTableRecords($this->forms->where('status', BasicStatus::Active))
            ->assertCanNotSeeTableRecords($this->forms->where('status', '!=', BasicStatus::Active))
            ->filterTable('status', BasicStatus::Inactive->value)
            ->assertCanSeeTableRecords($this->forms->where('status', BasicStatus::Inactive))
            ->assertCanNotSeeTableRecords($this->forms->where('status', '!=', BasicStatus::Inactive));
    });
});

describe('authorized user with form create permissions', function () {
    beforeEach(fn () => signIn(permissions: 'form.create'));

    test('has the correct permissions', function () {
        $form = $this->forms->first();

        livewire(FormsList::class)
            ->assertActionVisible(TestAction::make('preview')->table($form))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($form))
            ->assertActionHidden(TestAction::make('design')->table($form))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($form));
    });
});

describe('authorized user with form delete permissions', function () {
    beforeEach(fn () => signIn(permissions: 'form.delete'));

    test('has the correct permissions', function () {
        $form = $this->forms->first();

        livewire(FormsList::class)
            ->assertActionVisible(TestAction::make('preview')->table($form))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($form))
            ->assertActionHidden(TestAction::make('design')->table($form))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($form));
    });
});

describe('authorized user with form update permissions', function () {
    beforeEach(fn () => signIn(permissions: 'form.update'));

    test('has the correct permissions', function () {
        $form = $this->forms->first();

        livewire(FormsList::class)
            ->assertActionVisible(TestAction::make('preview')->table($form))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($form))
            ->assertActionVisible(TestAction::make('design')->table($form))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($form));
    });
});

describe('authorized user with form view permissions', function () {
    beforeEach(fn () => signIn(permissions: 'form.view'));

    test('has the correct permissions', function () {
        $form = $this->forms->first();

        livewire(FormsList::class)
            ->assertActionVisible(TestAction::make('preview')->table($form))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($form))
            ->assertActionHidden(TestAction::make('design')->table($form))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($form));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the manage forms page', function () {
        get(route('admin.forms.index'))->assertNotFound();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage forms page', function () {
        get(route('admin.forms.index'))->assertRedirectToRoute('login');
    });
});
