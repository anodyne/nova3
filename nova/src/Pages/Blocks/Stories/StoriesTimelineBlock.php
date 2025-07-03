<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

use Closure;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;

class StoriesTimelineBlock extends StoriesBlock
{
    const component = 'stories.timeline';

    protected ?string $blockLabel = 'Stories - Timeline block';

    protected string|Closure|null $preview = 'stories.timeline';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Timeline options')
                ->icon(iconName('timeline'))
                ->schema([
                    Radio::make('block.timelineSorting')->options([
                        'asc' => 'Oldest stories first',
                        'desc' => 'Newest stories first',
                    ]),
                ]),
        ];
    }
}
