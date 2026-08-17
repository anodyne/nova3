<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Opcodes\LogViewer\Facades\LogViewer;
use Opcodes\LogViewer\LogFile;
use Opcodes\LogViewer\LogFileCollection;
use Opcodes\LogViewer\Logs\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @property-read ?LogFile $logFile
 * @property-read ?array $logs
 * @property-read LogFileCollection $files
 */
class ErrorLogViewer extends Component
{
    public ?string $selectedLogFile = null;

    #[Computed]
    public function logFile(): ?LogFile
    {
        return LogViewer::getFile($this->selectedLogFile);
    }

    #[Computed]
    public function logs(): ?array
    {
        $file = LogViewer::getFile($this->selectedLogFile);

        if ($file) {
            return $file->logs()->reverse()->get();
        }

        return null;
    }

    #[Computed]
    public function files(): LogFileCollection
    {
        return LogViewer::getFiles()->take(14);
    }

    public function getStacktrace(Log $log): ?string
    {
        if (Arr::isMultiDimensional($log->context)) {
            foreach ($log->context as $key => $value) {
                if (Arr::has($value, 'exception')) {
                    return Arr::get($value, 'exception');
                }
            }

            return null;
        }

        return Arr::get($log->context, 'exception');
    }

    public function deleteLogFile(): void
    {
        $this->logFile->delete();

        $this->selectedLogFile = null;

        Notification::make()->success()
            ->title('Log file has been deleted')
            ->send();
    }

    public function downloadLogFile(): BinaryFileResponse
    {
        return $this->logFile->download();
    }

    public function render()
    {
        return view('pages.dashboards.livewire.error-log-viewer', [
            'files' => $this->files,
            'logFile' => $this->logFile,
            'logs' => $this->logs,
        ]);
    }
}
