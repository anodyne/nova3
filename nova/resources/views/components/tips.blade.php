@if ($hasTips())
    <div class="mx-auto mt-16 w-full max-w-2xl">
        <x-callout.primary heading="Quick tip" :icon="Tabler::Bulb">
            {{ $getRandomTip }}
        </x-callout.primary>
    </div>
@endif
