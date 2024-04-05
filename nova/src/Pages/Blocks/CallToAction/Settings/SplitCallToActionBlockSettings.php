<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction\Settings;

class SplitCallToActionBlockSettings extends CallToActionBlockSettings
{
    public ?string $header = 'Split CTA block';

    public ?string $identifier = 'cta-split';

    public function mount(): void
    {
        $this->form->fill([
            'heading' => $this->data['heading'] ?? null,
            'description' => $this->data['description'] ?? null,

            'bgOption' => $this->data['bgOption'] ?? null,
            'bgColor' => $this->data['bgColor'] ?? null,
            'bgImage' => $this->data['bgImage'] ?? null,
            'bgImageIntensity' => $this->data['bgImageIntensity'] ?? null,

            'dark' => $this->data['dark'] ?? false,

            'spacingHorizontal' => $this->data['spacingHorizontal'] ?? null,
            'spacingVertical' => $this->data['spacingVertical'] ?? null,

            'primaryButtonLabel' => $this->data['primaryButtonLabel'] ?? null,
            'primaryButtonUrl' => $this->data['primaryButtonUrl'] ?? null,
            'primaryButtonColorOption' => $this->data['primaryButtonColorOption'] ?? null,
            'primaryButtonBgColor' => $this->data['primaryButtonBgColor'] ?? null,
            'primaryButtonTextColor' => $this->data['primaryButtonTextColor'] ?? null,

            'secondaryButtonLabel' => $this->data['secondaryButtonLabel'] ?? null,
            'secondaryButtonUrl' => $this->data['secondaryButtonUrl'] ?? null,

            'card' => $this->data['card'] ?? null,
            'cardBg' => $this->data['cardBg'] ?? null,
            'cardBgOpacity' => $this->data['cardBgOpacity'] ?? null,
            'cardBgBlur' => $this->data['cardBgBlur'] ?? null,
            'cardSpacing' => $this->data['cardSpacing'] ?? null,
            'cardDark' => $this->data['cardDark'] ?? null,
        ]);
    }
}
