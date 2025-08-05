<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Update Nova</h1>

        <p class="text-lg/8 text-gray-600">
            Let’s run the update process to get your site up to the latest version of Nova.
        </p>
    </header>

    @if ($shouldShowForm)
        <div class="mx-auto max-w-lg space-y-12">
            @if ($errorMessage)
                <x-panel.danger title="Error updating Nova" :icon="Icon::AlertCircle">
                    {{ $errorMessage }}
                </x-panel.danger>
            @endif

            <div class="flex items-center justify-center">
                <x-button.setup type="button" wire:click="update" :leading="Icon::RefreshDot">
                    <div class="flex items-center gap-3">
                        <div>Run update</div>
                        <x-icon.loader
                            class="size-5 animate-spin text-white"
                            wire:loading
                            wire:target="update"
                        ></x-icon.loader>
                    </div>
                </x-button.setup>
            </div>
        </div>
    @endif

    @if ($shouldShowSuccessTable)
        <div class="mx-auto max-w-lg space-y-8">
            <x-panel variant="well">
                <x-panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5" variant="inset">
                    @include('setup.update-nova._check-updated')
                    @include('setup.update-nova._check-update-settings')
                    @include('setup.update-nova._send-telemetry')
                    @include('setup.update-nova._database-maintenance')
                </x-panel>
            </x-panel>
        </div>

        <div class="flex items-center justify-center gap-8">
            <x-button.setup href="{{ route('admin.dashboard') }}" :leading="Icon::ArrowRightCircle">
                Back to the site
            </x-button.setup>
        </div>
    @endif
</div>
