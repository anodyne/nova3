<?php

declare(strict_types=1);

namespace Nova\Ranks\Concerns;

use Symfony\Component\Finder\Finder;

trait FindRankImages
{
    protected function getRankBaseImages(): array
    {
        return $this->getRankImages('base');
    }

    protected function getRankOverlayImages(): array
    {
        return $this->getRankImages('overlay');
    }

    protected function getRankImages(string $path): array
    {
        $finder = new Finder;
        $finder->in(base_path("ranks/{$path}"))->files();

        $images = [];

        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $images[$file->getRelativePathname()] = $file->getRelativePathname();
            }
        }

        asort($images);

        return $images;
    }
}
