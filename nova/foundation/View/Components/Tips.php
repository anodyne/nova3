<?php

namespace Nova\Foundation\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Tips extends Component
{
    public $tips;

    public $section;

    public function __construct(string $section)
    {
        $this->section = $section;
        $this->tips = config("tips.{$section}", []);
    }

    public function getRandomTip(): string
    {
        return Arr::random($this->tips);
    }

    public function hasTips(): bool
    {
        return count($this->tips) > 0;
    }

    public function render()
    {
        return view('components.tips');
    }
}
