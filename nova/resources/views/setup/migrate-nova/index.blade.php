@use('Nova\Setup\Enums\NovaMigrateStatus')

<div
    class="mx-auto max-w-7xl space-y-16"
    x-data="{
        celebrate() {
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 },
            })
        },
    }"
    x-on:confetti.window="celebrate()"
>
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <x-setup::page-heading>Migrate from Nova 2</x-setup::page-heading>

        <x-setup::page-subheading>
            Easily move your existing data from Nova 2 to the new Nova 3 format.
        </x-setup::page-subheading>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-setup::panel variant="well">
            <x-setup::panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5" variant="inset">
                @if ($status === NovaMigrateStatus::InsufficientLegacyVersion)
                    @include('setup.migrate-nova._legacy-version')
                @else
                    @include('setup.migrate-nova._configure-database')
                    @include('setup.migrate-nova._migrate-data')
                    @include('setup.migrate-nova._set-user-access')
                @endif
            </x-setup::panel>
        </x-setup::panel>

        @if ($status?->isSuccessful())
            <div class="flex items-center justify-center">
                <x-setup::button :href="route('login')">
                    Start using Nova
                    <span aria-hidden="true">→</span>
                </x-setup::button>
            </div>
        @endif
    </div>
</div>

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
@endPushOnce
