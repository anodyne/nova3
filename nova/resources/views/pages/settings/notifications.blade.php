@extends($meta->template)

@section('content')
    <x-page-header title="Notifications Settings" x-data="{}">
        <x-slot name="controls">
            <x-button type="button" color="white" size="sm" @click="$dispatch('toggle-spotlight')">
                @icon('search', 'h-5 w-5')
                <span class="ml-2">Find a setting</span>
            </x-button>
        </x-slot>
    </x-page-header>

    <x-panel x-data="tabsList('global')">
        <div>
            <x-content-box class="sm:hidden">
                <select @change="switchTab($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-6 focus:outline-none focus:ring focus:border-blue-7 transition ease-in-out duration-200 sm:text-sm rounded-md">
                    <option value="global">Global</option>
                    <option value="group">Group Notifications</option>
                    <option value="individual">Individual Notifications</option>
                </select>
            </x-content-box>
            <div class="hidden sm:block">
                <div class="border-b border-gray-6 px-4 sm:px-6">
                    <nav class="-mb-px flex">
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-7 text-blue-11': isTab('global'), 'text-gray-9 hover:text-gray-11 hover:border-gray-6': isNotTab('global') }" @click.prevent="switchTab('global')">
                            Global
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-7 text-blue-11': isTab('group'), 'text-gray-9 hover:text-gray-11 hover:border-gray-6': isNotTab('group') }" @click.prevent="switchTab('group')">
                            Group Notifications
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-7 text-blue-11': isTab('individual'), 'text-gray-9 hover:text-gray-11 hover:border-gray-6': isNotTab('individual') }" @click.prevent="switchTab('individual')">
                            Individual Notifications
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <x-form :action="route('settings.update')" method="PUT" id="discord" :divide="false" :space="false">
            <x-form.section title="Global Discord Settings" message="You can set global settings for the Discord webhook and accent color to use for all Discord notifications. These settings can be used instead of duplicating the values in each of your notifications." x-show="isTab('global')">
                <x-input.group label="Discord Webhook" for="webhook" :error="$errors->first('webhook')">
                    <x-slot name="help">
                        <ol class="list-inside list-decimal ml-0.5 text-gray-11 space-y-1 text-sm">
                            <li>From your Discord server, go to Server Settings > Webhooks</li>
                            <li>Create a new webhook and enter the channel you'd like notifications to be sent to</li>
                            <li>Copy the webhook URL and paste it in the field above</li>
                        </ol>
                    </x-slot>

                    <x-input.text id="webhook" name="webhook" :value="old('webhook', $settings->discord->webhook)" placeholder="https://discordapp.com/api/webhooks/..." />
                </x-input.group>

                <x-input.group label="Accent Color" for="color">
                    <x-buk-color-picker name="color" id="color" :value="old('color', $settings->discord->color)" />
                </x-input.group>
            </x-form.section>

            <div x-show="isTab('group')" x-cloak>
                <ul>
                    @foreach ($systemNotifications->where('category', 'group') as $systemNotification)
                        <li class="border-t border-gray-6 hover:bg-gray-2 first:border-0 transition duration-200 ease-in-out">
                            <div class="block">
                                <div class="px-4 py-4 flex items-center sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="flex-1 flex items-center space-x-3 font-medium">
                                            {{ $systemNotification->name }}
                                        </div>
                                        <div class="mt-2 flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-x-6 sm:space-y-0 text-gray-9">
                                            <x-badge size="xs" :color="$systemNotification->discordStatusBadgeColor">Discord</x-badge>
                                            <x-badge size="xs" :color="$systemNotification->emailStatusBadgeColor">Email</x-badge>
                                            <x-badge size="xs" :color="$systemNotification->webStatusBadgeColor">Web</x-badge>
                                        </div>
                                    </div>
                                    <div class="ml-5 flex-shrink-0 leading-0">
                                        <x-button color="gray-text">
                                            @icon('edit', 'h-5 w-5')
                                        </x-button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div x-show="isTab('individual')" x-cloak>
                <ul>
                    @foreach ($systemNotifications->where('category', 'individual') as $systemNotification)
                        <li class="border-t border-gray-6 hover:bg-gray-2 first:border-0 transition duration-200 ease-in-out">
                            <div class="block">
                                <div class="px-4 py-4 flex items-center sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="flex-1 flex items-center space-x-3 font-medium">
                                            {{ $systemNotification->name }}
                                        </div>
                                        <div class="mt-2 flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-x-6 sm:space-y-0 text-gray-9">
                                            <x-badge size="xs" :color="$systemNotification->emailStatusBadgeColor">Email</x-badge>
                                            <x-badge size="xs" :color="$systemNotification->webStatusBadgeColor">Web</x-badge>
                                        </div>
                                    </div>
                                    <div class="ml-5 flex-shrink-0 leading-0">
                                        <x-button color="gray-text">
                                            @icon('edit', 'h-5 w-5')
                                        </x-button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <x-form.footer>
                <x-button type="submit" form="discord" color="blue">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection