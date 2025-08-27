<x-setup::panel.row
    :icon="Tabler::Puzzle"
    heading="Required PHP extensions"
    x-data="{ expanded: {{ Js::from($e->extensions->fails()) }} }"
>
    <p>
        Nova and its underlying framework require specific PHP extensions to be enabled for different features to be
        used.
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
        class="rounded-full bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-600 ring-1 ring-gray-500/10 transition ring-inset hover:bg-gray-100"
        x-on:click="expanded = !expanded"
    >
        <span x-show="expanded" x-cloak>Hide the full list of required extensions &uarr;</span>
        <span x-show="!expanded">Show the full list of required extensions &darr;</span>
    </button>

    <div x-show="expanded" class="mt-6" x-collapse x-cloak>
        <dl class="space-y-1">
            @foreach ($e->extensions->requiredExtensions() as $extension)
                <div class="flex items-center rounded-md px-3 py-2 odd:bg-gray-950/5">
                    <dt class="flex-1 font-medium text-gray-900">
                        {{ $extension['name'] }}
                    </dt>
                    <dd class="ml-6 flex shrink-0 items-center">
                        <x-icon
                            :name="in_array($extension['key'], $e->extensions->loaded) ? Tabler::CircleCheck : Tabler::CircleX"
                            @class([
                                'text-success-500' => in_array($extension['key'], $e->extensions->loaded),
                                'text-danger-500' => ! in_array($extension['key'], $e->extensions->loaded),
                            ])
                            size="lg"
                        />
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>

    <x-slot name="trailing">
        @if ($e->extensions->passes())
            <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
        @else
            <x-icon :name="Tabler::CircleX" class="text-danger-500" size="lg" />
        @endif
    </x-slot>
</x-setup::panel.row>
