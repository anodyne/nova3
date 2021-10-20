<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class Editor extends Component
{
    public bool $codeView = false;

    public string $content = '';

    public function updatedContent($value): void
    {
        $this->emit('postContentUpdated', $value);
    }

    public function getWordCountProperty(): int
    {
        return Str::of($this->content)->pipe('strip_tags')->wordCount();
    }

    public function render()
    {
        return view('livewire.editor');
    }
}
