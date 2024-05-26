<?php

declare(strict_types=1);

namespace Nova\Forms\Fields\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Str;
use Nova\Foundation\Scribble\ScribbleModal;
use Nova\Roles\Models\Role;

abstract class FieldSettings extends ScribbleModal
{
    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

    public function getFormData(): array
    {
        return [
            'name' => $this->data['name'] ?? null,
            'label' => $this->data['label'] ?? null,
            'description' => $this->data['description'] ?? null,
            'uid' => $this->data['uid'] ?? null,
        ];
    }

    public function formFields(array $fields = []): array
    {
        return [
            Section::make('Field info')
                ->description('Customize the label and description text for a field')
                ->schema([
                    TextInput::make('label')
                        ->live()
                        ->debounce(750)
                        ->afterStateUpdated(fn ($state, Set $set) => $set('name', str($state)->slug())),
                    Textarea::make('description')
                        ->rows(3)
                        ->helperText('Provide any information you think would be helpful for users filling out the form'),
                    TextInput::make('name')
                        ->required()
                        ->helperText('The name must be unique for each field in the form'),
                    TextInput::make('uid')
                        ->label('ID')
                        ->helperText('This is a unique identifier for the field. You can safely leave this as the generated value unless you need a specific value set for the field’s ID.')
                        ->formatStateUsing(fn (Set $set, ?string $state): string => $state ?? $set('uid', Str::random(12))),
                ]),
            ...$fields,
            Section::make('Field settings')->schema([
                Toggle::make('required')
                    ->label('Require this field to have a value'),
                Toggle::make('hideWhenEmpty')
                    ->label('Hide this field from displaying if there is no value'),
                Select::make('roles')
                    ->label('Restrict this field to users with one of these roles')
                    ->helperText('Restricting a field to specific roles will apply to both filling out the form as well as displaying its values')
                    ->multiple()
                    ->options(Role::all()->pluck('display_name', 'name')),
            ]),
        ];
    }
}
