@php
    $e = nova()->environment();
@endphp

<x-setup-layout type="update">
    <div class="mx-auto max-w-7xl space-y-16">
        <header class="mx-auto max-w-2xl space-y-6 text-center">
            <x-setup::page-heading>What’s new?</x-setup::page-heading>

            <x-setup::page-subheading>
                We’re constantly striving to make Nova better with each release. Learn about the changes in this latest
                version of Nova. When you’re ready, you can continue on to run the updater.
            </x-setup::page-subheading>
        </header>

        <div class="flex items-center justify-center">
            <x-setup::button :href="url('setup/update')" :leading="Tabler::RefreshDot">Update Nova</x-setup::button>
        </div>

        <div class="mx-auto max-w-2xl space-y-8">
            <x-setup::panel variant="well">
                <x-setup::panel.header
                    size="sm"
                    title="Summary of changes"
                    description="Below is a summary of the changes that will be applied with this update"
                ></x-setup::panel.header>

                <x-setup::panel>
                    <x-spacing size="sm">
                        <livewire:nova-version-history :start="$versionComingFrom" :end="$versionGoingTo" />
                    </x-spacing>
                </x-setup::panel>
            </x-setup::panel>
        </div>
    </div>
</x-setup-layout>
