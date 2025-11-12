<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Anodyne\TablerIcons\Tabler;
use Filament\Forms\Components\Builder\Block as BuilderBlock;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

abstract class Field extends BuilderBlock
{
    protected ?string $component = null;

    protected ?string $blockLabel = null;

    protected bool $showOtherHtmlAttributesField = true;

    protected bool $isContentField = false;

    protected function setUp(): void
    {
        parent::setUp();

        if ($this->isContentField) {
            $schema = $this->detailsSchema();
        } else {
            $schema = [
                Tabs::make()
                    ->tabs([
                        Tab::make('details')
                            ->label('Basic details')
                            ->icon(Tabler::InfoCircle)
                            ->schema([
                                ...$this->infoSchema(),
                                ...$this->requiredSchema(),
                                ...$this->detailsSchema(),
                            ]),
                        Tab::make('attrs')
                            ->label('Attributes')
                            ->icon(Tabler::ListDetails)
                            ->schema($this->baseAttributesSchema($this->attributesSchema()))
                            ->hidden($this->isContentField),
                    ])
                    ->contained(false),
            ];
        }

        $this->label($this->blockLabel)
            ->schema($schema)
            ->preview('components.form-fields.'.$this->preview);
    }

    abstract public function attributesSchema(): array;

    abstract public function detailsSchema(): array;

    protected function infoSchema(): array
    {
        if ($this->isContentField) {
            return [];
        }

        return [
            TextInput::make('details.label')
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, Set $set) => $set('attrs.name', str($state)->slug()->toString())),

            Textarea::make('details.description')
                ->rows(3)
                ->helperText('Provide any information you think would be helpful for users filling out the form'),
        ];
    }

    protected function requiredSchema(): array
    {
        if ($this->isContentField) {
            return [];
        }

        return [
            Toggle::make('details.required')
                ->label('Require this field to have a value'),

            Toggle::make('details.hideWhenEmpty')
                ->label('Hide this field from displaying if there is no value'),
        ];
    }

    protected function baseAttributesSchema(array $fieldDefinedAttributes = []): array
    {
        $attributes = [
            TextInput::make('attrs.name')
                ->required()
                ->helperText('The name must be unique for each field in the form'),

            TextInput::make('attrs.id')
                ->label('ID')
                ->helperText('This is a unique identifier for the field. You can safely leave this as the generated value unless you need a specific value set for the field’s ID.')
                ->formatStateUsing(fn (Set $set, ?string $state): string => $state ?? $set('attrs.id', Str::random(12))),

            ...$fieldDefinedAttributes,
        ];

        if ($this->showOtherHtmlAttributesField) {
            $attributes[] = KeyValue::make('attrs.other')
                ->label('Other HTML attributes')
                ->helperText('Add any HTML attributes you want to your field')
                ->addActionLabel('Add attribute')
                ->keyLabel('Attribute');
        }

        return $attributes;
    }
}
