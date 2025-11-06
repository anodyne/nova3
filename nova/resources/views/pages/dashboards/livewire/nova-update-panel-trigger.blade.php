<button
    type="button"
    @class([
        'group relative isolate inline-flex items-center gap-3 text-sm',
        '-mr-3' => $trailingText,
    ])
    wire:slide-over="nova-update-panel"
>
    <div
        @class([
            'relative z-1 flex items-center gap-1.5 rounded-full px-3 py-1 text-sm/6 font-semibold ring-1 ring-inset',
            'bg-success-50 text-success-600 ring-success-600/20 dark:bg-success-500/10 dark:text-success-400 dark:ring-success-500/25' => ! $needsFilesUpdate && ! $needsDatabaseUpdate,
            'bg-info-50 text-info-600 ring-info-600/20 dark:bg-info-500/10 dark:text-info-400 dark:ring-info-500/25' => ! $needsFilesUpdate && $needsDatabaseUpdate,
            'bg-danger-50 text-danger-600 ring-danger-600/20 dark:bg-danger-500/10 dark:text-danger-400 dark:ring-danger-500/25' => $needsFilesUpdate && $hasCriticalUpdate,
            'bg-warning-50 text-warning-600 ring-warning-600/20 dark:bg-warning-500/10 dark:text-warning-400 dark:ring-warning-500/25' => $needsFilesUpdate && ! $hasCriticalUpdate,
        ])
    >
        <span>{{ $leadingText }}</span>

        @if ($hasUpcomingUpdate)
            <x-icon.micro.calendar class="shrink-0"></x-icon.micro.calendar>
        @endif
    </div>

    @if ($trailingText)
        <div class="relative z-1 mr-3 flex items-center gap-1">
            {{ $trailingText }}
            <span aria-hidden="true">→</span>
        </div>
    @endif

    <div
        class="absolute -inset-x-1 -inset-y-1 z-0 scale-95 rounded-full bg-gray-950/5 opacity-0 transition group-hover:scale-100 group-hover:opacity-100 dark:bg-white/5"
    ></div>
</button>
