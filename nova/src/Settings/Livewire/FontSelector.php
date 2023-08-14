<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FontSelector extends Component
{
    public ?string $provider = null;

    public ?string $family = null;

    public function getLocalFontsProperty(): array
    {
        return collect(Storage::disk('dist')->directories('fonts'))
            ->flatMap(function (string $dir) {
                $dir = str($dir)->replace('fonts/', '')->replace('-', ' ')->title()->toString();

                return [$dir => $dir];
            })
            ->sortKeys()
            ->all();
    }

    public function mount()
    {
        $this->provider = settings('appearance.fontProvider') ?? 'local';
        $this->family = settings('appearance.fontFamily') ?? 'Inter';
    }

    public function render()
    {
        return view('livewire.settings.font-selector', [
            'localFonts' => $this->localFonts,
        ]);
    }
}
