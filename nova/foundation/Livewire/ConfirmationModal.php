<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Livewire\Attributes\Locked;

class ConfirmationModal extends Modal
{
    #[Locked]
    public string $callbackComponent = '';

    /**
     * @var array{title?: string, message?: string, confirm?: string, cancel?: string, icon?: string}
     */
    public array $prompt = [];

    public ?string $confirmPhrase = null;

    public ?string $confirmPhraseInput = null;

    public string $theme = 'warning';

    /**
     * @param  array{title?: string, message?: string, confirm?: string, cancel?: string, icon?: string}  $prompt
     */
    public function mount(
        string $callbackComponent,
        array $prompt = [],
        ?string $confirmPhrase = null,
        string $theme = 'warning',
    ): void {
        $this->callbackComponent = $callbackComponent;

        $this->prompt = array_merge([
            'title' => 'Are you sure?',
            'message' => 'This action cannot be undone.',
            'confirm' => 'Yes, continue',
            'cancel' => 'Cancel',
        ], $prompt);

        $this->confirmPhrase = $confirmPhrase;
        $this->theme = $theme;
    }

    public function confirm(): void
    {
        $this->validate();

        $this->dispatch('actionConfirmed')->to($this->callbackComponent);

        $this->close();
    }

    public function render(): View
    {
        return view('livewire.confirmation-modal');
    }

    public static function size(): string
    {
        return 'lg';
    }

    /**
     * @return array<string, list<In|string>>
     */
    protected function rules(): array
    {
        return [
            'confirmPhraseInput' => filled($this->confirmPhrase)
                ? ['required', Rule::in([$this->confirmPhrase])]
                : ['nullable'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'confirmPhraseInput.in' => "Please enter \"{$this->confirmPhrase}\" to continue.",
        ];
    }
}
