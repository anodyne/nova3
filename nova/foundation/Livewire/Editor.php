<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read string $wordCount
 */
class Editor extends Component
{
    public bool $codeView = false;

    public ?string $content = null;

    public string $fieldName = 'editor-content';

    public function updatedContent($value): void
    {
        dump($value);
        $this->dispatch('editorUpdated', $this->content);
    }

    #[Computed]
    public function wordCount(): string
    {
        return number_format(str($this->content)->pipe('strip_tags')->wordCount());
    }

    public function render(): Factory|View
    {
        return view('livewire.editor', [
            'wordCount' => $this->wordCount,
        ]);
    }
}
