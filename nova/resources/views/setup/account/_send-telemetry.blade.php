@use('Illuminate\Support\Number')
@use('Nova\Setup\Telemetry')

@php
    $telemetryData = (new Telemetry)->gatherFullHeartbeatData();
@endphp

<x-setup::panel.row :icon="Tabler::Broadcast" heading="Send telemetry data" x-data="{ expanded: false }">
    <p>
        Nova sends basic data about your server and game to Anodyne for support purposes and general platform
        statistics. You can see the full set of data sent to Anodyne below and learn more about telemetry data and how
        it’s used in the
        {{-- format-ignore-start --}}
        <a href="{{ external_content('telemetry-guide') }}" target="_blank" class="text-primary-500 hover:text-primary-600 underline font-medium">telemetry guide</a>.
        {{-- format-ignore-end --}}
    </p>

    <button
        class="rounded-full bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-600 ring-1 ring-gray-500/10 transition ring-inset hover:bg-gray-100"
        x-on:click="expanded = !expanded"
    >
        <span x-show="expanded" x-cloak>Hide the full list of telemetry data &uarr;</span>
        <span x-show="!expanded">Show the full list of telemetry data &darr;</span>
    </button>

    <div x-show="expanded" class="mt-6" x-collapse x-cloak>
        <dl class="space-y-1">
            @foreach ($telemetryData as $key => $value)
                <div class="flex items-center rounded-md px-3 py-2 odd:bg-gray-950/5">
                    <dt class="flex-1 text-sm/6 font-medium text-gray-900">
                        {{
                            str($key)
                                ->ucwords()
                                ->replace('_', ' ')
                                ->replace('Url', 'URL')
                                ->replace('Php', 'PHP')
                                ->replace('Db', 'Database')
                        }}
                    </dt>
                    <dd class="ml-6 flex shrink-0 items-center text-sm/6">
                        @if (is_numeric($value))
                            {{ Number::format($value) }}
                        @else
                            {{ $value }}
                        @endif
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>

    <x-slot name="trailing">
        <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
    </x-slot>
</x-setup::panel.row>
