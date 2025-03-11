<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Stories\Enums\ContentRatingValue;

class PostRatingsEditor extends SlideOver
{
    public ContentRatingValue $language;

    public ContentRatingValue $sex;

    public ContentRatingValue $violence;

    public function save(): void
    {
        $this->close(andDispatch: [
            'save-post-ratings' => [$this->language, $this->sex, $this->violence],
        ]);
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-ratings-editor');
    }

    public static function size(): string
    {
        return 'lg';
    }
}
