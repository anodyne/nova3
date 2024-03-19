<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Content\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Awcodes\Scribble\Livewire\ScribbleModal;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\ScribbleEditor;
use Filament\Support\Enums\MaxWidth;
use Nova\Pages\Blocks\FormSchema;

class FreeformContentBlockSettings extends ScribbleModal
{
    public ?string $header = 'Freeform Content block';

    public ?string $identifier = 'content';

    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::FourExtraLarge;
    }

    public function mount(): void
    {
        $this->form->fill([
            'content' => $this->data['content'] ?? null,

            'bgOption' => $this->data['bgOption'] ?? null,
            'bgColor' => $this->data['bgColor'] ?? null,

            'spacingHorizontal' => $this->data['spacingHorizontal'] ?? null,
            'spacingVertical' => $this->data['spacingVertical'] ?? null,

            'dark' => $this->data['dark'] ?? false,
        ]);
    }

    public function getFormFields(): array
    {
        return [
            ScribbleEditor::make('content')
                ->profile(DefaultProfile::class)
                ->renderToolbar(),
            ...FormSchema::backgroundColor(),
        ];
    }
}
