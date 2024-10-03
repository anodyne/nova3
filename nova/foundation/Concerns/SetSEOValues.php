<?php

declare(strict_types=1);

namespace Nova\Foundation\Concerns;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\URL;

trait SetSEOValues
{
    protected array $seoData = [];

    protected function setSEOValues(): void
    {
        $this->setSEOTitle();

        $this->setSEODescription();

        $this->setSEOImage();

        $this->setSEOKeywords();

        $this->setSEOUrls();
    }

    protected function setSEOTitle(): void
    {
        $title = data_get($this->seoData, 'title', $this->page?->seo_title ?? $this->page?->name);

        SEOTools::setTitle($title);
    }

    protected function setSEODescription(): void
    {
        $description = data_get($this->seoData, 'description', $this->page?->seo_description);

        if (filled($description)) {
            SEOTools::setDescription($description);
        }
    }

    protected function setSEOImage(): void
    {
        $image = data_get($this->seoData, 'image', $this->page?->getFirstMediaUrl('seo-image'));

        if (filled($image)) {
            SEOTools::addImages($image);
        }
    }

    protected function setSEOKeywords(): void
    {
        $keywords = data_get($this->seoData, 'keywords', $this->page?->seo_keywords);

        if (filled($keywords)) {
            $keywords = explode(',', $keywords);

            SEOTools::metatags()->addKeyword($keywords);
        }
    }

    protected function setSEOUrls(): void
    {
        SEOTools::setCanonical(URL::current());
        SEOTools::opengraph()->setUrl(URL::current());
    }
}
