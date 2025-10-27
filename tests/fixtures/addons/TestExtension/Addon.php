<?php

declare(strict_types=1);

namespace Addons\TestExtension;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Nova\Addons\Extension;

class Addon extends Extension
{
    public string $location = 'TestExtension';

    public static bool $installCalled = false;

    public static bool $uninstallCalled = false;

    public static bool $updateCalled = false;

    public function install(): void
    {
        static::$installCalled = true;
    }

    public function uninstall(): void
    {
        static::$uninstallCalled = true;
    }

    public function update(): void
    {
        static::$updateCalled = true;
    }

    public function settingsForm(): array
    {
        return [
            TextInput::make('api_key')
                ->label('API Key')
                ->helperText('Enter your API key for testing'),
            Toggle::make('enabled')
                ->label('Enable feature')
                ->default(false),
        ];
    }

    public static function resetFlags(): void
    {
        static::$installCalled = false;
        static::$uninstallCalled = false;
        static::$updateCalled = false;
    }
}
