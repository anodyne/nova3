<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories\Settings;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Nova\Pages\Blocks\FormSchema;

class StoriesTimelineBlockSettings extends StoriesBlockSettings
{
    public ?string $header = 'Stories Timeline block';

    public ?string $identifier = 'stories-timeline-block';

    public function getFormFields(): array
    {
        return [
            ...FormSchema::heading(withOrientation: true),
            ...FormSchema::backgroundColor(),
            Section::make('Timeline options')->schema([
                Radio::make('timelineSorting')->options([
                    'asc' => 'Oldest stories first',
                    'desc' => 'Newest stories first',
                ]),
            ]),
        ];
    }
}
