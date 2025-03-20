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
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Migrate from Nova 2</h1>

        <p class="text-lg/8 text-gray-600">Easily move your existing data from Nova 2 to the new Nova 3 format.</p>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-panel variant="well">
            <x-panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5" variant="inset">
                @if ($status === NovaMigrateStatus::InsufficientLegacyVersion)
                    @include('setup.migrate-nova._legacy-version')
                @else
                    @include('setup.migrate-nova._configure-database')
                    @include('setup.migrate-nova._migrate-data')
                    @include('setup.migrate-nova._set-user-access')
                @endif
            </x-panel>
        </x-panel>

        @if ($status?->isSuccessful())
            <div class="flex items-center justify-center">
                <x-button.setup :href="route('login')" leading="arrow-right">Start using Nova</x-button.setup>
            </div>
        @endif
    </div>
</div>

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
@endPushOnce
