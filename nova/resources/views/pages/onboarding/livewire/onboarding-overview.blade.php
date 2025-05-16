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
        <x-empty-state>
            <x-illustration name="empty-onboarding" size="2xl"></x-illustration>
            <x-h2>No active onboardings</x-h2>
            <x-text>Congrats, everything has been setup.</x-text>
        </x-empty-state>
    @endif
</div>
