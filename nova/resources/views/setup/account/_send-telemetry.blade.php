@use('Illuminate\Support\Number')
@use('Nova\Setup\Telemetry')

@php
    $telemetryData = (new Telemetry)->gatherFullHeartbeatData();
@endphp

<x-spacing size="sm" class="col-span-3 grid grid-cols-subgrid">
    <div class="mr-4 shrink-0">
        <x-icon :name="Icon::Broadcast" size="xl" class="text-gray-500"></x-icon>
    </div>

    <div class="col-start-2" x-data="{ expanded: false }">
        <x-h4 class="leading-8">Send telemetry data</x-h4>

        <div class="mt-4 space-y-4 text-sm/6 font-normal text-gray-500">
            <p>
                Nova sends basic data about your server and game to Anodyne for support purposes and general platform
                statistics. You can see the full set of data sent to Anodyne below and learn more about telemetry data
                and how it’s used in the
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
        </div>

        <div x-show="expanded" class="mt-6" x-collapse x-cloak>
            <dl class="space-y-1">
                @foreach ($telemetryData as $key => $value)
                    <div class="flex items-center rounded-md px-3 py-2 odd:bg-gray-950/[.04]">
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
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        <x-icon :name="Icon::CheckCircle" class="text-primary-500" size="xl"></x-icon>
    </div>
</x-spacing>
