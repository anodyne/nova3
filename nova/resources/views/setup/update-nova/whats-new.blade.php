@php
    $e = nova()->environment();
@endphp

<x-setup-layout type="update">
    <div class="mx-auto max-w-7xl space-y-16">
        <header class="mx-auto max-w-2xl space-y-6 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">What’s new?</h1>

            <p class="text-lg/8 text-gray-600">
                We’re constantly striving to make Nova better with each release. Learn about the changes in this latest
                version of Nova. When you’re ready, you can continue on to run the updater.
            </p>
        </header>

        <div class="flex items-center justify-center">
            <x-button.setup :href="url('setup/update')" leading="update">Update Nova</x-button.setup>
        </div>

        <div class="mx-auto max-w-2xl space-y-8">
            <x-panel variant="well">
                <x-panel.header
                    size="sm"
                    title="Summary of changes"
                    description="Here is a summary of the changes that will be applied with this update."
                ></x-panel.header>

                <x-panel>
                    <x-spacing size="sm">
                        <livewire:nova-version-history :start="$versionComingFrom" :end="$versionGoingTo" />
                    </x-spacing>
                </x-panel>
            </x-panel>
        </div>
    </div>
</x-setup-layout>
