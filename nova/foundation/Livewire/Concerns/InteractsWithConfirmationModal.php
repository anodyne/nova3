<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire\Concerns;

use Livewire\Attributes\On;
use Nova\Foundation\Livewire\ConfirmationModal;
use ReflectionMethod;

trait InteractsWithConfirmationModal
{
    public bool $actionConfirmed = false;

    public string $confirmationCaller = '';

    /**
     * @var array<int, mixed>
     */
    public array $confirmationCallerArguments = [];

    /**
     * Run `$callback` once the user has confirmed the prompt.
     *
     * The first call opens the confirmation modal and records the calling
     * method so it can be replayed verbatim after confirmation; the replayed
     * call falls straight through to the callback.
     *
     * @param  array{title?: string, message?: string, confirm?: string, cancel?: string, icon?: string}  $prompt
     */
    public function askForConfirmation(
        callable $callback,
        array $prompt = [],
        ?string $confirmPhrase = null,
        string $theme = 'warning',
    ): void {
        if ($this->actionConfirmed) {
            $callback();

            $this->actionConfirmed = false;
            $this->confirmationCaller = '';
            $this->confirmationCallerArguments = [];

            return;
        }

        $trace = debug_backtrace();
        $caller = next($trace);

        $this->confirmationCaller = $caller['function'] ?? '';
        $this->confirmationCallerArguments = $caller['args'] ?? [];

        $this->dispatch(
            'modal-open',
            modal: ConfirmationModal::class,
            props: [
                'callbackComponent' => $this->getName(),
                'prompt' => $prompt,
                'confirmPhrase' => $confirmPhrase,
                'theme' => $theme,
            ],
        );
    }

    #[On('actionConfirmed')]
    public function actionConfirmed(): void
    {
        if ($this->confirmationCaller === '' || ! method_exists($this, $this->confirmationCaller)) {
            return;
        }

        if (! (new ReflectionMethod($this, $this->confirmationCaller))->isPublic()) {
            return;
        }

        $this->actionConfirmed = true;

        $this->{$this->confirmationCaller}(...$this->confirmationCallerArguments);
    }
}
