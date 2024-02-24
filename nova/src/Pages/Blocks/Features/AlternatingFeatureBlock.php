<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Nova\Pages\Blocks\FormSchema;

class AlternatingFeatureBlock extends FeatureBlock
{
    public ?string $label = 'Features - Alternating';

    public string $rendered = 'pages.pages.blocks.features.alternating';

    public string $preview = 'pages.pages.blocks.features.alternating';

    public string $width = '4xl';

    public function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            ...FormSchema::background(),
            ...FormSchema::dark(),
            Section::make('Features')->schema([
                Repeater::make('features')->schema([
                    TiptapEditor::make('content')
                        ->profile('simple')
                        ->output(TiptapOutput::Json)
                        ->blocks([]),
                    FileUpload::make('image')
                        ->disk('media')
                        ->directory('pages'),
                ]),
            ]),
        ];
    }
}
