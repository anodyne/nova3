<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\ContentRating;
use Nova\Stories\Enums\ContentRatingValue;

class ContentRatingsSettingsForm extends Form
{
    #[Validate]
    public ContentRatingValue $rating;

    public ?string $description0;

    public ?string $description1;

    public ?string $description2;

    public ?string $description3;

    public ContentRatingValue $warningThreshold;

    public ?string $warningThresholdMessage;

    public function rules(): array
    {
        return [
            'rating' => ['required'],
        ];
    }

    public function setRatings(ContentRating $rating): void
    {
        $this->rating = $rating->rating;
        $this->description0 = $rating->description0;
        $this->description1 = $rating->description1;
        $this->description2 = $rating->description2;
        $this->description3 = $rating->description3;
        $this->warningThreshold = $rating->warningThreshold;
        $this->warningThresholdMessage = $rating->warningThresholdMessage;
    }

    public function save(string $category): void
    {
        $this->validate();

        $settings = settings('ratings');

        $ratings = $settings->with([
            $category => ContentRating::from($this->all()),
        ]);

        UpdateSettings::run('ratings', $ratings);
    }
}
