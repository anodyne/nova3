<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Livewire\Component;

class PostingActivitySettings extends Component
{
    public PostingActivityForm $form;

    public function save(): void
    {
        $this->form->save();
    }

    public function mount()
    {
        $this->form->loadSettings();
    }

    public function render()
    {
        return view('pages.settings.livewire.posting-activity');
    }
}
