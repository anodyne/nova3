<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

trait WritesPost
{
    public $postId;

    public $title;

    public $day;

    public $time;

    public $location;

    public $content = '';

    public $post;

    public $ratingLanguage = 0;

    public $ratingSex;

    public $ratingViolence;

    public function daySelected($value): void
    {
        $this->day = $value;
    }

    public function locationSelected($value): void
    {
        $this->location = $value;
    }

    public function setPostContent($content): void
    {
        $this->content = $content;
    }

    public function timeSelected($value): void
    {
        $this->time = $value;
    }
}
