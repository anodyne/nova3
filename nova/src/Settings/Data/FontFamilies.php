<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Nova\Foundation\Fonts\BunnyFontProvider;
use Nova\Foundation\Fonts\Contracts\FontProvider;
use Nova\Foundation\Fonts\GoogleFontProvider;
use Nova\Foundation\Fonts\LocalFontProvider;
use Spatie\LaravelData\Data;

class FontFamilies extends Data
{
    public function __construct(
        public string $headerProvider,
        public string $headerFamily,
        public string $bodyProvider,
        public string $bodyFamily
    ) {}

    public function getFontHtml(): Htmlable
    {
        // x Fonts are the same and from the same provider
        // x Fonts are the same and from different providers (one is local)
        // x Fonts are the same and from different providers (neither is local)
        // - Fonts are different and from the same provider
        // - Fonts are different and from different providers

        $output = collect();

        if ($this->headerFamily === $this->bodyFamily) {
            if ($this->headerProvider === 'local' || $this->bodyProvider === 'local') {
                $output->push($this->getFontProvider('local')->getFontHtml($this->headerFamily));
            } else {
                $provider = $this->getFontProvider($this->headerProvider);

                $output->push($provider->getPreconnectHtml());
                $output->push($provider->getFontHtml($this->headerFamily));
            }
        } else {
            if ($this->headerProvider === $this->bodyProvider && $this->headerProvider !== 'local') {
                $output->push($this->getFontProvider($this->headerProvider)->getPreconnectHtml());
            } else {
                $output->push($this->getFontProvider($this->headerProvider)->getPreconnectHtml());
                $output->push($this->getFontProvider($this->bodyProvider)->getPreconnectHtml());
            }

            $output->push($this->getFontProvider($this->headerProvider)->getFontHtml($this->headerFamily));
            $output->push($this->getFontProvider($this->bodyProvider)->getFontHtml($this->bodyFamily));
        }

        return new HtmlString(implode("\n", $output->filter()->all()));
    }

    public function getFontProvider(string $provider): FontProvider
    {
        return match ($provider) {
            'bunny' => new BunnyFontProvider,
            'google' => new GoogleFontProvider,
            default => new LocalFontProvider,
        };
    }
}
