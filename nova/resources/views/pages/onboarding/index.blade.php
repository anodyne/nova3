@use('Nova\Foundation\Version')

@php
    $version = Version::make(Nova::filesVersion());
@endphp

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header description="Let’s setup your Nova experience with the steps below">
            <x-slot name="heading">Welcome to Nova {{ $version->short() }}</x-slot>
        </x-page-header>

        <livewire:onboarding-overview />
    </x-spacing>
</x-admin-layout>
