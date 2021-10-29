<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class Editor extends Component
{
    public bool $codeView = false;

    public string $content = '';

    public string $fieldName = 'editor-content';

    public function updatedContent($value): void
    {
        $this->emit('postContentUpdated', $value);
    }

    public function getWordCountProperty(): string
    {
        return number_format(Str::of($this->content)->pipe('strip_tags')->wordCount());
    }

    public function mount($content = '', $fieldName = 'editor-content')
    {
        $this->content = $content;
        $this->fieldName = $fieldName;
    }

    public function render()
    {
        return view('livewire.editor');
    }
}
