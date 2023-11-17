<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class Editor extends Component
{
    public bool $codeView = false;

    public ?string $content = null;

    public string $fieldName = 'editor-content';

    public function updatedContent(): void
    {
        $this->dispatch('editorUpdated', $this->content);
    }

    #[Computed]
    public function wordCount(): string
    {
        return number_format(str($this->content)->pipe('strip_tags')->wordCount());
    }

    public function render()
    {
        return view('livewire.editor', [
            'wordCount' => $this->wordCount,
        ]);
    }
}
