<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Nova\Foundation\Livewire\SlideOver;

class PostSummaryEditor extends SlideOver
{
    public ?string $summary = null;

    public function save(): void
    {
        $this->close(andDispatch: [
            'update-post-summary' => [$this->summary],
        ]);
    }

    public function mount(?string $summary): void
    {
        $this->summary = $summary;
    }

    public function render(): View
    {
        return view('pages.posts.livewire.post-summary-editor');
    }

    public static function size(): string
    {
        return 'xl';
    }
}
