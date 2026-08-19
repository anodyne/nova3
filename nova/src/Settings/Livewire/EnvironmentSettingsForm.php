<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Nova\Foundation\Rules\Boolean;
use Nova\Settings\Actions\UpdateEnvironment;
use Nova\Settings\Data\EnvironmentConfiguration;
use Nova\Settings\Enums\ServerEnvironment;

class EnvironmentSettingsForm extends Form
{
    public ServerEnvironment $environment;

    public bool $debugMode;

    public string $url;

    public function populate(): void
    {
        $this->environment = ServerEnvironment::tryFrom(config('app.env')) ?? ServerEnvironment::Production;
        $this->debugMode = (bool) config('app.debug');
        $this->url = config('app.url');
    }

    public function save(): void
    {
        $this->validate();

        $environmentConfiguration = EnvironmentConfiguration::from($this->all());

        UpdateEnvironment::run($environmentConfiguration);
    }

    protected function rules(): array
    {
        return [
            'environment' => ['required', Rule::enum(ServerEnvironment::class)],
            'debugMode' => [new Boolean],
            'url' => ['required'],
        ];
    }
}
