@if ($hasTips())
    <div class="mx-auto mt-16 w-full max-w-2xl">
        <x-panel.primary title="Quick tip" icon="bulb" icon-size="xl" :description="$getRandomTip"></x-panel.primary>
    </div>
@endif
