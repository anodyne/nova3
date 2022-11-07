<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire\Concerns;

use Livewire\Livewire;
use ReflectionMethod;

trait WithConfirmationModal
{
    public bool $actionConfirmed = false;

    public string $confirmationCaller;

    public array $confirmationCallerArguments = [];

    public function bootWithConfirmationModal()
    {
        $this->listeners = array_merge(
            $this->listeners,
            $this->getListeners(),
            ['actionConfirmed' => 'actionConfirmed']
        );
    }

    public function askForConfirmation(
        callable $callback,
        array $prompt = [],
        $theme = 'warning',
        $modalCloseArguments = [],
    ): void {
        if ($this->actionConfirmed) {
            $callback();
            $this->actionConfirmed = false;

            return;
        }

        $trace = debug_backtrace();
        $trace = next($trace);

        $this->confirmationCaller = $trace['function'] ?? null;
        $this->confirmationCallerArguments = $trace['args'] ?? [];

        $this->emit('openModal', 'confirmation-modal', [
            Livewire::getAlias(self::class, self::getName()),
            $prompt,
            $theme,
            $modalCloseArguments,
        ]);
    }

    public function actionConfirmed()
    {
        if (method_exists($this, $this->confirmationCaller)) {
            $reflection = new ReflectionMethod($this, $this->confirmationCaller);
            if ($reflection->isPublic()) {
                $this->actionConfirmed = true;
                $this->{$this->confirmationCaller}(...$this->confirmationCallerArguments);
            }
        }
    }
}
