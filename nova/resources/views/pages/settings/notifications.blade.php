@extends($meta->template)

@section('content')
    <x-panel x-data="tabsList('settings')">
        <x-panel.header title="Notification settings">
            <x-slot:actions>
                <div x-data="{}">
                    <x-button.outline color="primary" leading="search" @click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button.outline>
                </div>
            </x-slot:actions>

            <div>
                <x-content-box class="sm:hidden">
                    <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                        <option value="settings">Settings</option>
                        <option value="admin">Administrative Notifications</option>
                        <option value="collective">Collective Notifications</option>
                        <option value="personal">Personal Notifications</option>
                    </x-input.select>
                </x-content-box>
                <div class="hidden sm:block">
                    <x-content-box height="none">
                        <nav class="-mb-px flex">
                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('settings'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('settings') }" @click.prevent="switchTab('settings')">
                                Settings
                            </a>
                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('admin'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('admin') }" @click.prevent="switchTab('admin')">
                                Administrative Notifications
                            </a>
                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('collective'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('collective') }" @click.prevent="switchTab('collective')">
                                Collective Notifications
                            </a>
                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('personal'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('personal') }" @click.prevent="switchTab('personal')">
                                Personal Notifications
                            </a>
                        </nav>
                    </x-content-box>
                </div>
            </div>
        </x-panel.header>

        <x-form :action="route('settings.update')" method="PUT" id="discord" :divide="false" :space="false">
            <x-form.section title="Discord Settings" message="You can set global settings for the Discord webhook and accent color to use for all Discord notifications. These settings can be used instead of duplicating the values in each of your notifications." x-show="isTab('settings')">
                <x-input.group label="Discord Webhook" for="webhook" :error="$errors->first('webhook')">
                    <x-input.text id="webhook" name="webhook" :value="old('webhook', $settings->discord->webhook)" placeholder="https://discordapp.com/api/webhooks/..." />

                    <x-slot:help>
                        <ol class="list-inside list-decimal ml-0.5 space-y-1 text-sm">
                            <li>From your Discord server, go to Server Settings > Webhooks</li>
                            <li>Add a webhook and enter the channel where notifications should go</li>
                            <li>Copy the webhook URL and paste it in the field above</li>
                        </ol>
                    </x-slot:help>
                </x-input.group>

                <x-input.group label="Accent Color" for="color">
                    <x-input.color name="color" id="color" :value="old('color', $settings->discord->color)"></x-input.color>
                </x-input.group>
            </x-form.section>

            <div x-show="isTab('admin')" x-cloak>
                <ul>
                    @foreach ($systemNotifications->where('type', Nova\Foundation\Enums\SystemNotificationType::admin) as $systemNotification)
                        <li class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50/50 dark:hover:bg-gray-700/20 first:border-0 transition">
                            <div class="block">
                                <div class="px-4 py-4 flex items-center sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="flex-1 flex items-center space-x-3 font-medium">
                                            {{ $systemNotification->name }}
                                        </div>
                                        <div class="mt-2 flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-x-6 sm:space-y-0 text-gray-500">
                                            <x-badge :color="$systemNotification->discordStatusBadgeColor">Discord</x-badge>
                                            <x-badge :color="$systemNotification->emailStatusBadgeColor">Email</x-badge>
                                            <x-badge :color="$systemNotification->webStatusBadgeColor">In-app</x-badge>
                                        </div>
                                    </div>
                                    <div class="ml-5 shrink-0 leading-0">
                                        <x-button.text
                                            color="gray"
                                            x-on:click="Livewire.emit('openModal', 'settings:notification-setting', {{ json_encode([$systemNotification, null]) }})"
                                        >
                                            <x-icon name="edit" size="sm"></x-icon>
                                        </x-button.text>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div x-show="isTab('collective')" x-cloak>
                <ul>
                    @foreach ($systemNotifications->where('type', Nova\Foundation\Enums\SystemNotificationType::collective) as $systemNotification)
                        <li class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50/50 dark:hover:bg-gray-700/20 first:border-0 transition">
                            <div class="block">
                                <div class="px-4 py-4 flex items-center sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="flex-1 flex items-center space-x-3 font-medium">
                                            {{ $systemNotification->name }}
                                        </div>
                                        <div class="mt-2 flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-x-6 sm:space-y-0 text-gray-500">
                                            <x-badge :color="$systemNotification->discordStatusBadgeColor">Discord</x-badge>
                                            <x-badge :color="$systemNotification->emailStatusBadgeColor">Email</x-badge>
                                            <x-badge :color="$systemNotification->webStatusBadgeColor">In-app</x-badge>
                                        </div>
                                    </div>
                                    <div class="ml-5 shrink-0 leading-0">
                                        <x-button.text
                                            color="gray"
                                            x-on:click="Livewire.emit('openModal', 'settings:notification-setting', {{ json_encode([$systemNotification, null]) }})"
                                        >
                                            <x-icon name="edit" size="sm"></x-icon>
                                        </x-button.text>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div x-show="isTab('personal')" x-cloak>
                <ul>
                    @foreach ($systemNotifications->where('type', Nova\Foundation\Enums\SystemNotificationType::personal) as $systemNotification)
                        <li class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50/50 dark:hover:bg-gray-700/20 first:border-0 transition">
                            <div class="block">
                                <div class="px-4 py-4 flex items-center sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="flex-1 flex items-center space-x-3 font-medium">
                                            {{ $systemNotification->name }}
                                        </div>
                                        <div class="mt-2 flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-x-6 sm:space-y-0 text-gray-500">
                                            <x-badge :color="$systemNotification->emailStatusBadgeColor">Email</x-badge>
                                            <x-badge :color="$systemNotification->webStatusBadgeColor">In-app</x-badge>
                                        </div>
                                    </div>
                                    <div class="ml-5 shrink-0 leading-0">
                                        <x-button.text
                                            color="gray"
                                            x-on:click="Livewire.emit('openModal', 'settings:notification-setting', {{ json_encode([$systemNotification, null]) }})"
                                        >
                                            <x-icon name="edit" size="sm"></x-icon>
                                        </x-button.text>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <x-form.footer>
                <x-button.filled type="submit" form="discord" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
