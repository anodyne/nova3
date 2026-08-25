<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read array<string, string> $localFonts
 * @property-read ?string $fontFamilyInputName
 * @property-read ?string $fontProviderInputName
 */
class FontSelector extends Component
{
    public ?string $section = null;

    public ?string $type = null;

    public ?string $provider = null;

    public ?string $providerInputName = null;

    public ?string $family = null;

    public ?string $familyInputName = null;

    public function updatedFamily(?string $value): void
    {
        $this->dispatch('font-updated', data: [
            'section' => $this->section,
            'type' => $this->type,
            'provider' => $this->provider,
            'family' => $this->family,
        ]);

        // if ($this->provider === 'local') {
        //     $this->dispatch('dropdown-close');
        // }
    }

    // public function mount()
    // {
    //     $fonts = settings("appearance.{$this->section}Fonts");

    //     $providerVariable = "{$this->type}Provider";
    //     $familyVariable = "{$this->type}Family";

    //     $this->provider = $fonts->{$providerVariable} ?? 'local';
    //     $this->family = $fonts->{$familyVariable} ?? 'Inter';
    // }

    public function render(): Factory|View
    {
        return view('pages.settings.livewire.font-selector', [
            'fontFamilyInputName' => $this->fontFamilyInputName,
            'fontProviderInputName' => $this->fontProviderInputName,
            'localFonts' => $this->localFonts,
        ]);
    }

    /** @return array<string, string> */
    #[Computed]
    public function localFonts(): array
    {
        return collect(Storage::disk('dist')->directories('fonts'))
            ->flatMap(function (string $dir): array {
                $dir = str($dir)->replace('fonts/', '')->replace('-', ' ')->title()->toString();

                return [$dir => $dir];
            })
            ->sortKeys()
            ->all();
    }

    #[Computed]
    public function fontFamilyInputName(): ?string
    {
        if (filled($this->familyInputName)) {
            return $this->familyInputName;
        }

        return sprintf('%s_fonts[%sFamily]', $this->section, $this->type);
    }

    #[Computed]
    public function fontProviderInputName(): ?string
    {
        if (filled($this->providerInputName)) {
            return $this->providerInputName;
        }

        return sprintf('%s_fonts[%sProvider]', $this->section, $this->type);
    }
}
