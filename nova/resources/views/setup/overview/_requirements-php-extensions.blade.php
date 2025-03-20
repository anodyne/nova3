<x-spacing class="col-span-3 grid grid-cols-subgrid" size="sm">
    <div class="mr-4 shrink-0">
        <x-icon name="puzzle" class="text-gray-500" size="xl"></x-icon>
    </div>

    <div class="col-start-2" x-data="{ expanded: @js($e->extensions->fails()) }">
        <x-h3 class="leading-8">Required PHP extensions</x-h3>

        <div class="mt-2 space-y-4 text-sm/6 font-normal text-gray-500">
            <p>
                Nova and its underlying framework require specific PHP extensions to be enabled for different features
                to be used.
            </p>

            @if (count($e->extensions->missingExtensions()) > 0)
                <p>
                    The version of PHP your server is running is missing
                    {{ str('extension')->plural(count($e->extensions->missingExtensions()))->prepend(count($e->extensions->missingExtensions()).' ') }}.
                    Please contact your web host for assistance with fixing this issue.
                </p>
            @endif

            <p>The following PHP extensions are required:</p>

            <button
                class="rounded-full bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition hover:bg-gray-100"
                x-on:click="expanded = !expanded"
            >
                <span x-show="expanded" x-cloak>Hide the full list of required extensions &uarr;</span>
                <span x-show="!expanded">Show the full list of required extensions &darr;</span>
            </button>
        </div>

        <div x-show="expanded" class="mt-6" x-collapse x-cloak>
            <dl class="space-y-1">
                @foreach ($e->extensions->requiredExtensions() as $extension)
                    <div class="flex items-center rounded-md px-3 py-2 odd:bg-gray-950/[.04]">
                        <dt class="flex-1 font-medium text-gray-900">
                            {{ $extension['name'] }}
                        </dt>
                        <dd class="ml-6 flex shrink-0 items-center">
                            <x-icon
                                :name="in_array($extension['key'], $e->extensions->loaded) ? 'check-circle' : 'x-circle'"
                                @class([
                                    'text-success-500' => in_array($extension['key'], $e->extensions->loaded),
                                    'text-danger-500' => ! in_array($extension['key'], $e->extensions->loaded),
                                ])
                                size="lg"
                            ></x-icon>
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        @if ($e->extensions->passes())
            <x-icon name="check-circle" class="text-primary-500" size="xl"></x-icon>
        @else
            <x-icon name="x-circle" class="text-danger-500" size="xl"></x-icon>
        @endif
    </div>
</x-spacing>
