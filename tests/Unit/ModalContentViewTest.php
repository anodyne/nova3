<?php

declare(strict_types=1);

use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;

it('returns the configured modal content view', function () {
    $action = new class
    {
        use HasModalContentView;

        public function configuredModalContentView(): string
        {
            return $this->getModalContentView();
        }
    };

    expect($action->modalContentView('filament.actions.confirmation'))->toBe($action)
        ->and($action->configuredModalContentView())->toBe('filament.actions.confirmation');
});

it('rejects an unconfigured modal content view', function () {
    $action = new class
    {
        use HasModalContentView;

        public function configuredModalContentView(): string
        {
            return $this->getModalContentView();
        }
    };

    expect(fn (): string => $action->configuredModalContentView())
        ->toThrow(LogicException::class, 'A modal content view must be configured before rendering the action.');
});
