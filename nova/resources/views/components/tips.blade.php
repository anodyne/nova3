@if ($hasTips())
    <div class="w-full max-w-2xl mx-auto mt-16">
        <x-panel.purple icon="lightbulb" height="sm" width="sm">
            {{ $getRandomTip }}
        </x-panel.purple>
    </div>
@endif