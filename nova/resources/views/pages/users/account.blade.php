@extends($meta->template)

@section('content')
    <div x-data="tabsList('{{ $tab }}')">
        <x-spacing constrained>
            <x-page-header>
                <x-slot name="heading">Account settings</x-slot>
            </x-page-header>

            <x-tab.group name="account">
                <x-tab.heading name="info">User info</x-tab.heading>
                <x-tab.heading name="preferences">Preferences</x-tab.heading>
                <x-tab.heading name="notifications">Notifications</x-tab.heading>
                <x-tab.heading name="delete">Delete my account</x-tab.heading>
            </x-tab.group>

            <x-form :action="route('account.update')" :space="false" class="mt-8">
                <div x-show="isTab('info')" x-cloak>
                    <x-spacing constrained>
                        <livewire:my-account-info />
                    </x-spacing>
                </div>

                <div x-show="isTab('notifications')" x-cloak>
                    <livewire:profile-notification-preferences />
                </div>

                <div x-show="isTab('preferences')" x-cloak>
                    <x-spacing constrained>
                        <livewire:my-account-preferences />
                    </x-spacing>
                </div>

                <div x-show="isTab('delete')" x-cloak>
                    <x-spacing constrained>
                        <livewire:delete-my-account />
                    </x-spacing>
                </div>
            </x-form>
        </x-spacing>
    </div>
@endsection
