<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Nova\Foundation\Environment\Database;
use Nova\Setup\Enums\DatabaseConfigStatus;
use Nova\Setup\Enums\SetupType;
use Nova\Setup\Livewire\Concerns\HandlesMigration;
use Nova\Setup\Livewire\Concerns\InteractsWithEnvFile;
use Nova\Setup\Livewire\Concerns\InteractsWithRoute;
use PDO;
use Stringable;
use Throwable;

/**
 * @property-read bool $shouldShowForm
 * @property-read bool $shouldShowManualInstructions
 * @property-read bool $shouldShowSuccessTable
 * @property-read bool $shouldShowDatabaseOptions
 * @property-read string $codeForEnv
 */
#[Layout('layouts.setup', ['type' => SetupType::Install])]
class ConfigureDatabase extends Component
{
    use HandlesMigration;
    use InteractsWithEnvFile;
    use InteractsWithRoute;

    public string $driver = 'mysql';

    public string $host = 'localhost';

    public string $port = '3306';

    public string $database = '';

    public string $prefix = '';

    public string $username = '';

    public string $password = '';

    public string $socket = '';

    public ?string $errorMessage = null;

    public ?DatabaseConfigStatus $status = null;

    /** @return array<string, list<string|Stringable>> */
    public function rules(): array
    {
        return [
            'driver' => ['required'],
            'host' => ['required'],
            'port' => ['required'],
            'database' => ['required'],
            'username' => ['required'],
            'password' => ['nullable'],
            'prefix' => [Rule::requiredIf(fn (): bool => $this->isMigrating && $this->useSameDatabase)],
            'socket' => ['nullable'],
        ];
    }

    public function connectToDatabase(): void
    {
        try {
            $this->validate();

            $this->testDatabaseConnection('test-'.$this->driver);

            $this->writeEnvironmentFile();

            $this->verifyDatabaseConnection();

            $this->verifyDatabaseVersionCompatibility();

            // $this->status = DatabaseConfigStatus::Success;
        } catch (ValidationException $ex) {
            if ($ex->validator->errors()->hasAny(['host', 'port', 'socket'])) {
                $this->dispatch('advanced-settings-validation-error');
            }

            $this->validate();
        } catch (Throwable $th) {
            $this->setErrorMessage($th);

            report($th);
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

    public function updatedDriver(string $value): void
    {
        $this->port = match ($value) {
            'pgsql' => '5432',
            default => '3306',
        };
    }

    #[Computed]
    public function shouldShowForm(): bool
    {
        return match ($this->status) {
            DatabaseConfigStatus::FailedToVerify => false,
            DatabaseConfigStatus::FailedToWriteEnv => false,
            DatabaseConfigStatus::IncompatibleDriver => false,
            DatabaseConfigStatus::IncompatibleVersion => false,
            DatabaseConfigStatus::AlreadyConfigured => false,
            DatabaseConfigStatus::Success => false,
            default => true,
        };
    }

    #[Computed]
    public function shouldShowManualInstructions(): bool
    {
        return match ($this->status) {
            DatabaseConfigStatus::FailedToWriteEnv => true,
            DatabaseConfigStatus::FailedToVerify => true,
            default => false,
        };
    }

    #[Computed]
    public function shouldShowSuccessTable(): bool
    {
        return match ($this->status) {
            DatabaseConfigStatus::IncompatibleDriver => true,
            DatabaseConfigStatus::IncompatibleVersion => true,
            DatabaseConfigStatus::Success => true,
            default => false,
        };
    }

    public function mount(): void
    {
        try {
            $this->verifyDatabaseConnection();

            $this->status = DatabaseConfigStatus::AlreadyConfigured;
        } catch (Throwable $th) {
            report($th);
        }
    }

    public function render(): Factory|View
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
        ]);
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
        if (str($connection)->startsWith('test-')) {
            config([
                "database.connections.{$connection}.host" => $this->host,
                "database.connections.{$connection}.port" => $this->port,
                "database.connections.{$connection}.database" => $this->database,
                "database.connections.{$connection}.prefix" => $this->prefix,
                "database.connections.{$connection}.username" => $this->username,
                "database.connections.{$connection}.password" => $this->password,
            ]);
        }

        DB::reconnect($connection)->getPdo();
    }

    protected function canConnectToDatabase(): bool
    {
        try {
            $connection = $this->isMigrating ? 'nova2' : $this->driver;

            DB::reconnect($connection)->getPdo();

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    protected function verifyDatabaseConnection(): void
    {
        try {
            $connection = $this->isMigrating ? 'nova2' : $this->driver;

            DB::reconnect($connection)->getPdo();
        } catch (Throwable $th) {
            if ($this->status instanceof DatabaseConfigStatus) {
                $this->status = DatabaseConfigStatus::FailedToVerify;
            }

            throw $th;
        }
    }

    protected function verifyDatabaseVersionCompatibility(): void
    {
        $database = new Database;

        if (! $database->passesVersion()) {
            $this->status = DatabaseConfigStatus::IncompatibleVersion;
        }

        if (! $database->passesDriver()) {
            $this->status = DatabaseConfigStatus::IncompatibleDriver;
        }

        if ($database->passes()) {
            $this->status = DatabaseConfigStatus::Success;
        }
    }

    protected function getPdoVersion(PDO $pdo): ?string
    {
        return str($pdo->getAttribute(PDO::ATTR_SERVER_VERSION))->before('-')->toString();
    }

    protected function getPdoDriver(PDO $pdo): ?string
    {
        if (str($pdo->getAttribute(PDO::ATTR_SERVER_VERSION))->contains('mariadb', ignoreCase: true)) {
            return 'mariadb';
        }

        return strtolower($pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
    }
}
