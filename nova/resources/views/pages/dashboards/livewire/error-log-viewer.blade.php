@use('Illuminate\Support\Arr')
@use('Illuminate\Support\Str')
@use('Nova\Foundation\Helpers\DateHelper')
@use('Nova\Foundation\Helpers\TimeHelper')

<div class="space-y-8">
    <div class="flex items-center gap-x-4">
        <x-select wire:model.live="selectedLogFile">
            <option value="">Choose a log file</option>

            @foreach ($files as $file)
                <option value="{{ $file->identifier }}">{{ $file->name }}</option>
            @endforeach
        </x-select>

        @if (filled($selectedLogFile))
            <x-button wire:click="downloadLogFile" text>
                <x-icon name="download" size="sm"></x-icon>
            </x-button>

            <x-button
                wire:click="deleteLogFile"
                wire:confirm="Are you sure you want to delete this log file?"
                color="neutral-danger"
                text
            >
                <x-icon name="trash" size="sm"></x-icon>
            </x-button>
        @endif
    </div>

    @if (filled($selectedLogFile))
        <div class="flex items-center gap-x-8 text-sm/6">
            <div class="flex items-center gap-x-4">
                @foreach ($logFile->logs()->getLevelCounts() as $count)
                    @php
                        $badgeColor = match (strtolower($count->level->value)) {
                            'error', 'emergency' => 'danger',
                            'warning' => 'warning',
                            'info' => 'info',
                            default => 'gray'
                        };
                    @endphp

                    <x-badge :color="$badgeColor" pill>
                        {{ $count->level->value }}
                        <x-badge :color="$badgeColor" class="tabular-nums" pill>{{ $count->count }}</x-badge>
                    </x-badge>
                @endforeach
            </div>

            <x-metadata label="Log size" :value="$logFile->sizeFormatted()"></x-metadata>
        </div>

        <div class="space-y-2">
            @foreach ($logs as $logLine)
                <x-panel
                    wire:key="panel-{{ $logLine->index.$logLine->filePosition }}"
                    x-data="{ expanded: false }"
                    variant="well"
                >
                    <x-spacing size="row" class="cursor-pointer" x-on:click="expanded = ! expanded">
                        <div class="flex justify-between gap-x-8">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-x-4">
                                    <x-h5>
                                        <div
                                            @class([
                                                match (strtolower($logLine->level)) {
                                                    'error', 'emergency' => 'text-danger-500',
                                                    'warning' => 'text-warning-600',
                                                    'info' => 'text-info-500',
                                                    default => null,
                                                },
                                            ])
                                        >
                                            {{ $logLine->level }}
                                        </div>
                                    </x-h5>

                                    <div class="flex items-center font-mono text-xs/5 font-medium tracking-tight">
                                        {{ TimeHelper::formatLongTime($logLine->datetime) }}
                                    </div>
                                </div>

                                <div class="text-sm/6">
                                    {{ $logLine->message }}
                                </div>
                            </div>

                            <div class="flex gap-x-2">
                                {{--
                                    <button type="button" x-clipboard.raw="{{ $logLine->message }}">
                                    <x-icon name="copy" size="size-5"></x-icon>
                                    </button>
                                --}}

                                <button
                                    type="button"
                                    class="inline-flex shrink-0 text-gray-500 transition dark:text-gray-400"
                                    x-cloak
                                >
                                    <span x-show="expanded">
                                        <x-icon.chevron-down class="size-6"></x-icon.chevron-down>
                                    </span>
                                    <span x-show="!expanded">
                                        <x-icon.chevron-right class="size-6"></x-icon.chevron-right>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div
                            @class([
                                'flex hidden gap-x-3',
                                match (strtolower($logLine->level)) {
                                    'error', 'emergency' => 'bg-danger-50 text-danger-600',
                                    default => null,
                                },
                            ])
                        >
                            <div class="flex items-center">
                                <div
                                    @class([
                                        'inline-flex justify-center font-mono text-xs/5 font-semibold tracking-wider',
                                        'w-16 rounded-md px-1',
                                        match (strtolower($logLine->level)) {
                                            'error', 'emergency' => 'bg-danger-500 text-white',
                                            'warning' => 'bg-warning-500 text-warning-900',
                                            'info' => 'bg-info-500 text-white',
                                            default => 'bg-gray-500 text-white',
                                        },
                                    ])
                                >
                                    {{ $logLine->level }}
                                </div>
                            </div>

                            <div class="flex items-center font-mono text-xs/5">
                                {{ TimeHelper::formatLongTime($logLine->datetime) }}
                            </div>

                            <div class="flex flex-1 text-sm/6">
                                {{ $logLine->message }}
                            </div>

                            <div class="flex items-center gap-x-2">
                                <button type="button" x-clipboard.raw="{{ $logLine->message }}">
                                    <x-icon name="copy" size="size-5"></x-icon>
                                </button>

                                <button
                                    type="button"
                                    class="shrink-0 transition"
                                    x-on:click="expanded = ! expanded"
                                    x-cloak
                                >
                                    <span x-show="expanded">
                                        <x-icon.chevron-down class="size-5"></x-icon.chevron-down>
                                    </span>
                                    <span x-show="!expanded">
                                        <x-icon.chevron-right class="size-5"></x-icon.chevron-right>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </x-spacing>

                    <x-panel
                        class="divide-y divide-gray-950/5 dark:divide-white/5"
                        x-show="expanded"
                        x-collapse
                        x-cloak
                    >
                        <x-spacing size="row">
                            <x-h5>Context</x-h5>

                            <div class="mt-4 grid grid-cols-4 gap-4 text-sm/6">
                                @foreach (Arr::except($logLine->context, 'exception') as $key => $contextLine)
                                    @if (is_array($contextLine))
                                        @foreach (Arr::except($contextLine, 'exception') as $cKey => $cLine)
                                            <x-fieldset.field :label="$cKey">
                                                <x-text>{{ $cLine }}</x-text>
                                            </x-fieldset.field>
                                        @endforeach
                                    @else
                                        <x-fieldset.field :label="$key">
                                            <x-text>{{ $contextLine }}</x-text>
                                        </x-fieldset.field>
                                    @endif
                                @endforeach
                            </div>
                        </x-spacing>

                        @if ($this->getStacktrace($logLine) !== null)
                            <x-spacing size="row" x-data="{ showStacktrace: false }">
                                <x-h5>Stacktrace</x-h5>

                                <div class="mt-2 flex items-center gap-x-2">
                                    <x-button x-on:click="showStacktrace = ! showStacktrace">Show stacktrace</x-button>

                                    <livewire:copy-stacktrace-button
                                        :stacktrace="$this->getStacktrace($logLine)"
                                        wire:key="stacktrace-button-{{ $logLine->index.$logLine->filePosition }}"
                                    />
                                </div>

                                <div class="mt-4" x-show="showStacktrace" x-collapse>
                                    {{ $this->getStacktrace($logLine) }}
                                </div>
                            </x-spacing>
                        @endif
                    </x-panel>
                </x-panel>
            @endforeach
        </div>
    @endif
</div>
