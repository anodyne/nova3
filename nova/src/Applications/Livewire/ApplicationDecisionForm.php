<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Applications\Actions\AcceptApplicationManager;
use Nova\Applications\Actions\DenyApplicationManager;
use Nova\Applications\Data\ApplicationDecisionData;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;

class ApplicationDecisionForm extends Form
{
    #[Locked]
    public Application $application;

    #[Validate('required')]
    public ?ApplicationResult $result = null;

    #[Validate('required')]
    public ?string $message = null;

    public ?string $rankId = null;

    /** @var array<mixed> */
    public array $positions = [];

    public function save(): void
    {
        $this->validate();

        if ($this->result === ApplicationResult::Accept) {
            AcceptApplicationManager::run(
                application: $this->application,
                data: ApplicationDecisionData::from(
                    message: $this->message,
                    rank_id: $this->rankId,
                    positions: $this->positions
                )
            );
        }

        if ($this->result === ApplicationResult::Deny) {
            DenyApplicationManager::run(
                application: $this->application,
                data: ApplicationDecisionData::from(
                    message: $this->message
                )
            );
        }

    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;

        $this->rankId = $application->character->rank_id;
        $this->positions = $application->character->positions()->pluck('positions.id')->toArray();
    }
}
