<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Applications\Actions\AcceptApplicationManager;
use Nova\Applications\Actions\DenyApplicationManager;
use Nova\Applications\Data\ApplicationDecisionData;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;

class ApplicationDecisionForm extends Form
{
    public Application $application;

    #[Validate('required')]
    public ?ApplicationResult $result = null;

    #[Validate('required')]
    public ?string $message = null;

    public ?int $rankId = null;

    public array $positions = [];

    public function save(): void
    {
        $this->validate();

        AcceptApplicationManager::runIf(
            $this->result === ApplicationResult::Accept,
            application: $this->application,
            data: new ApplicationDecisionData(
                message: $this->message,
                rank_id: $this->rankId,
                positions: $this->positions
            )
        );

        DenyApplicationManager::runIf(
            $this->result === ApplicationResult::Deny,
            application: $this->application,
            data: new ApplicationDecisionData(
                message: $this->message
            )
        );
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;

        $this->positions = $application->character->positions()->pluck('positions.id')->all();
    }
}
