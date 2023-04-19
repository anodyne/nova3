<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Livewire\Component;

class Editor extends Component
{
    public bool $codeView = false;

    public ?string $content = null;

    public string $fieldName = 'editor-content';

    public function updatedContent($value): void
    {
        $this->emit('editorUpdated', $value);
    }

    public function getWordCountProperty(): string
    {
        return number_format(str($this->content)->pipe('strip_tags')->wordCount());
    }

    public function render()
    {
        return view('livewire.editor');
    }
}
