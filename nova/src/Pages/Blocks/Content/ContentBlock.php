<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Content;

use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapBlock;
use FilamentTiptapEditor\TiptapEditor;
use Nova\Pages\Blocks\FormSchema;

class ContentBlock extends TiptapBlock
{
    public string $width = '4xl';

    public bool $slideOver = true;

    public ?string $icon = 'tabler-text-size';

    public ?string $label = 'Content';

    public string $rendered = 'pages.pages.blocks.content.index';

    public string $preview = 'pages.pages.blocks.content.index';

    public function getFormSchema(): array
    {
        return [
            TiptapEditor::make('content')
                ->output(TiptapOutput::Json)
                ->blocks([]),
            ...FormSchema::backgroundColor(),
            ...FormSchema::dark(),
        ];
    }
}
