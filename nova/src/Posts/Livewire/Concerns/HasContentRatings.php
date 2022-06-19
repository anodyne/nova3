<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

trait HasContentRatings
{
    public int $ratingLanguage;

    public int $ratingSex;

    public int $ratingViolence;

    public function mountHasContentRatings(): void
    {
        $settings = settings();

        $this->ratingLanguage = $this->post?->rating_language ?? $settings->ratings->language->rating;
        $this->ratingSex = $this->post?->rating_sex ?? $settings->ratings->sex->rating;
        $this->ratingViolence = $this->post?->rating_violence ?? $settings->ratings->violence->rating;
    }

    public function contentRatingsUpdated(...$args): void
    {
        [$language, $sex, $violence] = $args;

        $this->ratingLanguage = $language;
        $this->ratingSex = $sex;
        $this->ratingViolence = $violence;

        $this->post->update([
            'rating_language' => $language,
            'rating_sex' => $sex,
            'rating_violence' => $violence
        ]);

        $this->post->fresh();
    }
}
