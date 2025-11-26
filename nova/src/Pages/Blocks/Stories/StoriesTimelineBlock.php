<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

use Anodyne\TablerIcons\Tabler;
use Closure;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Section;

class StoriesTimelineBlock extends StoriesBlock
{
    const component = 'stories.timeline';

    protected ?string $blockLabel = 'Stories - Timeline';

    protected string|Closure|null $preview = 'stories.timeline';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Timeline options')
                ->icon(Tabler::TimelineEvent)
                ->schema([
                    Radio::make('block.timelineSorting')->options([
                        'asc' => 'Oldest stories first',
                        'desc' => 'Newest stories first',
                    ]),
                ]),
        ];
    }
}
