<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Logos\Settings;

class SimpleLogosBlockSettings extends LogosBlockSettings
{
    public ?string $header = 'Simple Logos block';

    public ?string $identifier = 'logos-simple';

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

            'logos' => $this->data['logos'] ?? [],
        ]);
    }
}
