<button
    type="button"
    wire:slide-over="nova-update-panel"
    @class([
        'flex w-fit gap-3 rounded-[10px] border p-1 pr-3 shadow-sm hover:brightness-[102%] dark:bg-gray-800 dark:hover:brightness-[110%]',
        'border-success-200 bg-success-50 dark:border-success-500' => ! $needsFilesUpdate && ! $needsDatabaseUpdate,
        'border-info-200 bg-info-50 dark:border-info-500' => ! $needsFilesUpdate && $needsDatabaseUpdate,
        'border-danger-200 bg-danger-50 dark:border-danger-500' => $needsFilesUpdate && $hasCriticalUpdate,
        'border-warning-200 bg-warning-50 dark:border-warning-500' => $needsFilesUpdate && ! $hasCriticalUpdate,
    ])
>
    <div
        @class([
            'rounded-[6px] px-2 py-1 text-sm font-medium leading-none text-white dark:text-white',
            'bg-success-500 dark:bg-success-500/50' => ! $needsFilesUpdate && ! $needsDatabaseUpdate,
            'bg-info-500 dark:bg-info-500/50' => ! $needsFilesUpdate && $needsDatabaseUpdate,
            'bg-danger-500 dark:bg-danger-500/50' => $needsFilesUpdate && $hasCriticalUpdate,
            'bg-warning-500 dark:bg-warning-500/50' => $needsFilesUpdate && ! $hasCriticalUpdate,
        ])
    >
        {{ $leadingText }}
    </div>
    <div
        @class([
            'flex items-center gap-2 text-sm font-medium leading-none dark:text-gray-300',
            'text-success-600' => ! $needsFilesUpdate && ! $needsDatabaseUpdate,
            'text-info-600' => ! $needsFilesUpdate && $needsDatabaseUpdate,
            'text-danger-600' => $needsFilesUpdate && $hasCriticalUpdate,
            'text-warning-600' => $needsFilesUpdate && ! $hasCriticalUpdate,
        ])
    >
        {{ $trailingText }}

        @if ($hasUpcomingUpdate)
            <x-icon.micro.calendar class="shrink-0"></x-icon.micro.calendar>
        @endif
    </div>
</button>
