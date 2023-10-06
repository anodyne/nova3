<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Nova\Setup\Enums\DatabaseConfigStatus;
use PDO;
use Throwable;

class ConfigureDatabase extends Component
{
    use Concerns\HandlesMigration;
    use Concerns\InteractsWithEnvFile;

    public string $host = 'localhost';

    public string $port = '3306';

    public string $database = 'nova3';

    public string $prefix = '';

    public string $username = 'root';

    public string $password = '';

    public string $socket = '';

    public ?string $errorMessage = null;

    public ?DatabaseConfigStatus $status = null;

    public function rules()
    {
        return [
            'host' => ['required'],
            'port' => ['required'],
            'database' => ['required'],
            'username' => ['required'],
            'password' => ['nullable'],
            'prefix' => [Rule::requiredIf(fn () => $this->isMigrating && $this->useSameDatabase)],
            'socket' => ['nullable'],
        ];
    }

    public function connectToDatabase(): void
    {
        try {
            $this->validate();

            $this->testDatabaseConnection('test');

            $this->writeEnvironmentFile();

            $this->verifyDatabaseConnection();

            $this->verifyDatabaseVersionCompatibility();

            $this->status = DatabaseConfigStatus::success;
        } catch (ValidationException $ex) {
            if ($ex->validator->errors()->hasAny(['host', 'port', 'socket'])) {
                $this->dispatchBrowserEvent('advanced-settings-validation-error');
            }

            $this->validate();
        } catch (Throwable $th) {
            $this->setErrorMessage($th);

            // throw $th;
        }
    }

    public function verifyDatabase(): void
    {
        try {
            $this->verifyDatabaseConnection();

            $this->verifyDatabaseVersionCompatibility();
        } catch (Throwable $th) {
            $this->setErrorMessage($th);

            // throw $th;
        }
    }

    public function getShouldShowFormProperty(): bool
    {
        return match ($this->status) {
            DatabaseConfigStatus::failedToVerify => false,
            DatabaseConfigStatus::failedToWriteEnv => false,
            DatabaseConfigStatus::incompatibleDriver => false,
            DatabaseConfigStatus::incompatibleVersion => false,
            DatabaseConfigStatus::alreadyConfigured => false,
            DatabaseConfigStatus::success => false,
            default => true,
        };
    }

    public function getShouldShowManualInstructionsProperty(): bool
    {
        return match ($this->status) {
            DatabaseConfigStatus::failedToWriteEnv => true,
            DatabaseConfigStatus::failedToVerify => true,
            default => false,
        };
    }

    public function getShouldShowSuccessTableProperty(): bool
    {
        return match ($this->status) {
            DatabaseConfigStatus::incompatibleDriver => true,
            DatabaseConfigStatus::incompatibleVersion => true,
            DatabaseConfigStatus::success => true,
            default => false,
        };
    }

    public function mount()
    {
        try {
            $this->verifyDatabaseConnection();

            $this->status = DatabaseConfigStatus::alreadyConfigured;
        } catch (Throwable $th) {
            //throw $th;
        }
    }

    public function render()
    {
        $view = ($this->isMigrating)
            ? 'setup.configure-database.nova2-migrate'
            : 'setup.configure-database.fresh-install';

        return view($view, [
            'codeForEnv' => $this->codeForEnv,
            'shouldShowDatabaseOptions' => $this->shouldShowDatabaseOptions,
            'shouldShowForm' => $this->shouldShowForm,
            'shouldShowManualInstructions' => $this->shouldShowManualInstructions,
            'shouldShowSuccessTable' => $this->shouldShowSuccessTable,
        ])->layout('layouts.setup');
    }

    protected function setErrorMessage(Throwable $th): void
    {
        $this->errorMessage = match (true) {
            str($th->getMessage())->contains('access denied for user', true) => "We couldn't connect to your database with the credentials you entered. Please update the credentials and try again.",

            str($th->getMessage())->contains('unknown database', true) => "We could not find a database named {$this->database}. Please verify the information you entered and try again.",

            str($th->getMessage())->contains('connection refused', true) => 'Please check your port and try again.',

            str($th->getMessage())->contains('operation timed out', true) => "We couldn't connect to the database host. Please update the host and try again.",

            default => $th->getMessage(),
        };
    }

    protected function testDatabaseConnection(string $connection): void
    {
        if ($connection === 'test') {
            config([
                'database.connections.test.host' => $this->host,
                'database.connections.test.port' => $this->port,
                'database.connections.test.database' => $this->database,
                'database.connections.test.prefix' => $this->prefix,
                'database.connections.test.username' => $this->username,
                'database.connections.test.password' => $this->password,
            ]);
        }

        DB::reconnect($connection)->getPdo();
    }

    protected function canConnectToDatabase(): bool
    {
        try {
            $connection = $this->isMigrating ? 'nova2' : 'mysql';

            DB::reconnect($connection)->getPdo();

            return true;
        } catch (Throwable $th) {
            return false;
        }
    }

    protected function verifyDatabaseConnection(): void
    {
        try {
            $connection = $this->isMigrating ? 'nova2' : 'mysql';

            DB::reconnect($connection)->getPdo();
        } catch (Throwable $th) {
            if ($this->status !== null) {
                $this->status = DatabaseConfigStatus::failedToVerify;
            }

            throw $th;
        }
    }

    protected function verifyDatabaseVersionCompatibility(): void
    {
        $pdo = DB::connection()->getPdo();

        $this->status = DatabaseConfigStatus::success;

        if (version_compare('8.0', $pdo->getAttribute(PDO::ATTR_SERVER_VERSION), '>')) {
            $this->status = DatabaseConfigStatus::incompatibleVersion;
        }

        if (strtolower($pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) !== 'mysql') {
            $this->status = DatabaseConfigStatus::incompatibleDriver;
        }
    }
}
