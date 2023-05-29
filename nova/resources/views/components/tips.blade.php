@if ($hasTips())
    <div class="w-full max-w-2xl mx-auto mt-16">
        <x-panel.primary icon="bulb" title="Quick Tip" height="sm" width="sm">
            {{ $getRandomTip }}
        </x-panel.primary>
    </div>
@endif
