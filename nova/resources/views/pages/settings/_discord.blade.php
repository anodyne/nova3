<x-form :action="route('settings.update')" method="PUT" id="discord">
    <div x-data="{ storyPosts: {{ $settings->discord->storyPostsEnabled ? 'true' : 'false' }}, applications: false }">
        <div class="px-4 py-5 | sm:p-6">
            <h3 class="text-lg font-medium text-gray-900" id="renew-headline">
                Send story post notifications to Discord
            </h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                    <p>
                        You can configure Nova to send notifications for story posts to your Discord server through webhooks.
                    </p>
                </div>
                <div
                    x-on:toggle-changed="storyPosts = $event.detail"
                    class="mt-5 | sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center"
                >
                    <x-input.toggle field="storyPosts[enabled]" :value="$settings->discord->storyPostsEnabled" />
                </div>
            </div>
            <div x-show="storyPosts" class="mt-6 px-6 space-y-8">
                <x-input.group label="Discord Webhook" for="storyPosts[webhook]" :error="$errors->first('storyPosts[webhook]')">
                    <x-slot name="help">
                        <ol class="list-inside list-decimal ml-0.5 text-gray-500 space-y-1 text-sm">
                            <li>From your Discord server, go to Server Settings > Webhooks</li>
                            <li>Create a new webhook and enter the channel notifications should be sent to</li>
                            <li>Copy the webhook URL and paste it above</li>
                        </ol>
                    </x-slot>

                    <x-input.text id="storyPosts[webhook]" name="storyPosts[webhook]" :value="old('storyPosts[webhook]', $settings->discord->storyPostsWebhook)" placeholder="https://discordapp.com/api/webhooks/..." />
                </x-input.group>

                <x-input.group label="Accent Color" for="storyPosts[color]" help="You can set the accent color used for all story post notifications.">
                    <x-buk-color-picker name="color" id="color" :value="old('storyPosts[color]', $settings->discord->storyPostsColor)" />
                </x-input.group>
            </div>
        </div>

        <div class="px-4 py-5 | sm:p-6">
            <h3 class="text-lg font-medium text-gray-900" id="renew-headline">
                Send application notifications to Discord
            </h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                    <p>
                        You can configure Nova to send notifications for applications to your Discord server through webhooks. It's highly encouraged that you have those notifications sent to a private channel as they will contain prospective user information.
                    </p>
                </div>
                <div
                    x-on:toggle-changed="applications = $event.detail"
                    class="mt-5 | sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center"
                >
                    <x-input.toggle
                        field="active"
                        :value="old('active', false)"
                    />
                </div>
            </div>
            <div x-show="applications" class="mt-8 px-6 space-y-8">
                <x-input.group label="Discord Webhook">
                    <x-slot name="help">
                        <ol class="list-inside list-decimal ml-0.5 text-gray-500 space-y-1 text-sm">
                            <li>From your Discord server, go to Server Settings > Webhooks</li>
                            <li>Create a new webhook and enter the channel notifications should be sent to</li>
                            <li>Copy the webhook URL and paste it above</li>
                        </ol>
                    </x-slot>

                    <x-input.text placeholder="https://discordapp.com/api/webhooks/..." />
                </x-input.group>

                <x-input.group label="Accent Color" help="You can set the accent color used for all story post notifications.">
                    <x-buk-color-picker name="color" id="color" :value="old('storyPosts[color]', $settings->discord->storyPostsColor)" />
                </x-input.group>
            </div>
        </div>
    </div>

    <x-form.footer>
        <button type="submit" form="discord" class="button button-primary">Update Discord Settings</button>
    </x-form.footer>
</x-form>
