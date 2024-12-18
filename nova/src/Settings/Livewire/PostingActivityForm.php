<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Enums\PostingTarget;
use Nova\Settings\Enums\PostingTimeframe;

class PostingActivityForm extends Form
{
    public PostingTarget $target;

    public int $requirement;

    public PostingTimeframe $timeframe;

    public ?int $rollingDays = null;

    public function loadSettings(): void
    {
        $this->target = settings('posting_activity.target');
        $this->requirement = settings('posting_activity.requirement');
        $this->timeframe = settings('posting_activity.timeframe');
        $this->rollingDays = settings('posting_activity.rollingDays');
    }

    public function save(): void
    {
        $this->validate();

        $data = PostingActivity::from($this->all());

        UpdateSettings::run('posting_activity', $data);

        Notification::make()->success()
            ->title('Posting activity settings updated')
            ->send();
    }

    protected function rules()
    {
        return [
            'target' => ['required'],
            'requirement' => ['required', 'integer'],
            'timeframe' => ['required'],
            'rollingDays' => [Rule::requiredIf($this->timeframe === PostingTimeframe::Rolling)],
        ];
    }
}
