<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\RichEditor;

class ContentField extends Field
{
    const component = 'content';

    protected ?string $blockLabel = 'Content';

    protected string|Closure|null $preview = 'content-preview';

    protected bool $isContentField = true;

    public function attributesSchema(): array
    {
        return [];
    }

    public function detailsSchema(): array
    {
        return [
            RichEditor::make('details.content'),
        ];
    }
}
