<div>
    @if ($activeOnboardings->count() > 0)
        <div class="space-y-12">
            @foreach ($activeOnboardings as $onboarding)
                <livewire:onboarding-detail
                    :onboarding="$onboarding->model"
                    wire:key="onboarding-{{ $onboarding->model->id }}"
                />
            @endforeach
        </div>
    @else
        <x-empty variant="jumbo">
            <x-illustration :name="Illustration::RocketCog" />
            <x-empty.heading>No active onboardings</x-empty.heading>
            <x-empty.text>Congrats, everything has been setup.</x-empty.text>
        </x-empty>
    @endif
</div>
