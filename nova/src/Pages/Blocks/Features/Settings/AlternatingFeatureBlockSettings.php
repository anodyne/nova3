<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features\Settings;

use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\ScribbleEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Cache;

class AlternatingFeatureBlockSettings extends FeatureBlockSettings
{
    public ?string $header = 'Alternating Features block';

    public ?string $identifier = 'features-alternating';

    public function mount(): void
    {
        $this->form->fill([
            'heading' => $this->data['heading'] ?? null,
            'description' => $this->data['description'] ?? null,
            'headerOrientation' => $this->data['headerOrientation'] ?? null,

            'bgOption' => $this->data['bgOption'] ?? null,
            'bgColor' => $this->data['bgColor'] ?? null,

            'dark' => $this->data['dark'] ?? false,

            'spacingHorizontal' => $this->data['spacingHorizontal'] ?? null,
            'spacingVertical' => $this->data['spacingVertical'] ?? null,

            'features' => $this->data['features'] ?? [],
        ]);
    }

    public function getFormFields(): array
    {
        $page = Cache::get('page-designer-page');

        return [
            ...parent::getFormFields(),
            Section::make('Features')->schema([
                Repeater::make('features')->schema([
                    ScribbleEditor::make('content')
                        ->profile(DefaultProfile::class)
                        ->renderToolbar(),
                    FileUpload::make('image')
                        ->disk('media')
                        ->directory('pages/'.$page),
                ]),
            ]),
        ];
    }
}
