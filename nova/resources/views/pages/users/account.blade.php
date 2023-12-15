@extends($meta->template)

@section('content')
    <x-panel class="overflow-hidden" x-data="tabsList('{{ $tab }}')">
        <x-panel.header title="My account">
            <div>
                <x-content-box class="sm:hidden">
                    <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                        <option value="info">User info</option>
                        <option value="notifications">Notifications</option>
                        <option value="preferences">Preferences</option>
                        <option value="delete">Delete my account</option>
                    </x-input.select>
                </x-content-box>
                <div class="hidden sm:block">
                    <x-content-box height="none">
                        <nav class="-mb-px flex">
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('info'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('info') }"
                                x-on:click.prevent="switchTab('info')"
                            >
                                User info
                            </a>
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('notifications'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('notifications') }"
                                x-on:click.prevent="switchTab('notifications')"
                            >
                                Notifications
                            </a>
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('preferences'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('preferences') }"
                                x-on:click.prevent="switchTab('preferences')"
                            >
                                Preferences
                            </a>
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-danger-500 text-danger-600 dark:text-danger-500': isTab('delete'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('delete') }"
                                x-on:click.prevent="switchTab('delete')"
                            >
                                Delete my account
                            </a>
                        </nav>
                    </x-content-box>
                </div>
            </div>
        </x-panel.header>

        <x-form :action="route('account.update')" :divide="false" :space="false">
            <div x-show="isTab('info')" x-cloak>
                <livewire:my-account-info />
            </div>

            <div x-show="isTab('notifications')" x-cloak>
                <livewire:profile-notification-preferences />
            </div>

            <div x-show="isTab('preferences')" x-cloak>
                <livewire:my-account-preferences />
            </div>

            <div x-show="isTab('delete')" x-cloak>
                <livewire:delete-my-account />
            </div>
        </x-form>
    </x-panel>
@endsection
