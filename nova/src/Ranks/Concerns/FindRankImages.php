<?php

declare(strict_types=1);

namespace Nova\Ranks\Concerns;

use Symfony\Component\Finder\Finder;

trait FindRankImages
{
    protected function getRankBaseImages(): array
    {
        $finder = new Finder();
        $finder->in(base_path('ranks/base'))->files();

        $baseImages = [];

        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $baseImages[$file->getRelativePathname()] = $file->getRelativePathname();
            }
        }

        asort($baseImages);

        return $baseImages;
    }

    protected function getRankOverlayImages()
    {
        $finder = new Finder();
        $finder->in(base_path('ranks/overlay'))->files();

        $overlayImages = [];

        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $overlayImages[$file->getRelativePathname()] = $file->getRelativePathname();
            }
        }

        asort($overlayImages);

        return $overlayImages;
    }
}
