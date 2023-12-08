<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Users\Models\User;

class MyAccountPreferencesForm extends Form
{
    #[Validate]
    public string $timezone;

    public function rules(): array
    {
        return [
            'timezone' => ['required'],
        ];
    }

    public function setAccount(User $user): void
    {
        $this->timezone = $user->preferences->timezone ?? 'UTC';
    }

    public function save(): void
    {
        $this->validate();

        auth()->user()->update($this->all());
    }
}
