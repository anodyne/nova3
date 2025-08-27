<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <x-setup::page-heading>Update Nova</x-setup::page-heading>

        <x-setup::page-subheading>
            Let’s run the update process to get your site up to the latest version of Nova.
        </x-setup::page-subheading>
    </header>

    @if ($shouldShowForm)
        <div class="mx-auto max-w-lg space-y-12">
            @if ($errorMessage)
                <x-callout.danger heading="Error updating Nova" :icon="Tabler::AlertCircle">
                    {{ $errorMessage }}
                </x-callout.danger>
            @endif

            <div class="flex items-center justify-center">
                <x-setup::button type="button" wire:click="update" :leading="Tabler::RefreshDot">
                    <div class="flex items-center gap-3">
                        <div>Run update</div>
                        <x-icon.loader
                            class="size-5 animate-spin text-white"
                            wire:loading
                            wire:target="update"
                        ></x-icon.loader>
                    </div>
                </x-setup::button>
            </div>
        </div>
    @endif

    @if ($shouldShowSuccessTable)
        <div class="mx-auto max-w-lg space-y-8">
            <x-setup::panel variant="well">
                <x-setup::panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5" variant="inset">
                    @include('setup.update-nova._check-updated')
                    @include('setup.update-nova._check-update-settings')
                    @include('setup.update-nova._send-telemetry')
                    @include('setup.update-nova._database-maintenance')
                </x-setup::panel>
            </x-setup::panel>
        </div>

        <div class="flex items-center justify-center gap-8">
            <x-setup::button href="{{ route('admin.dashboard') }}">
                Back to the site
                <span aria-hidden="true">→</span>
            </x-setup::button>
        </div>
    @endif
</div>
