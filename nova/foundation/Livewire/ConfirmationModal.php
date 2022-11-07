<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use LivewireUI\Modal\ModalComponent;

class ConfirmationModal extends ModalComponent
{
    public mixed $callbackComponent;

    public array $prompt = [];

    public mixed $theme;

    public array $modalCloseArguments = [];

    public function mount($callbackComponent, array $prompt = [], $theme = 'warning', $modalCloseArguments = [])
    {
        $this->callbackComponent = $callbackComponent;

        $this->prompt = array_merge([
            'title' => 'Are you absolutely sure?',
            'message' => 'Are you sure you want to execute this action?',
            'confirm' => 'Confirm',
            'cancel' => 'Cancel',
        ], $prompt);

        $this->theme = $theme;
        $this->modalCloseArguments = $modalCloseArguments;
    }

    public function confirm()
    {
        $this->emitTo($this->callbackComponent, 'actionConfirmed');

        $this->dismiss();
    }

    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function render()
    {
        return view('livewire.confirmation-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }
}
