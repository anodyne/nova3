<x-filament.modal-content :$action color="bg-discord" title="Global Discord settings">
    <x-text>
        You can set the global settings for the Discord webhook and accent color for notifications below. When updating
        the settings for an individual Discord notification, you’ll be able to change to notification-specific settings
        if you need to.
    </x-text>

    <hr class="my-4 border-gray-950/10 dark:border-white/10" />

    <x-callout.primary heading="Instructions">
        <div class="flex flex-col gap-1 text-sm/6">
            <div class="grid grid-cols-[auto_1fr] gap-2">
                <div class="tabular-nums">1.</div>
                <div>
                    From your Discord server, navigate to Server Settings
                    <span aria-hidden="true">→</span>
                    Integrations
                    <span aria-hidden="true">→</span>
                    Webhooks
                </div>
            </div>
            <div class="grid grid-cols-[auto_1fr] gap-2">
                <div class="tabular-nums">2.</div>
                <div>Add a webhook and select the specific channel you’d like notifications sent to</div>
            </div>
            <div class="grid grid-cols-[auto_1fr] gap-2">
                <div class="tabular-nums">3.</div>
                <div>Copy the webhook URL and paste it in the field below</div>
            </div>
        </div>
    </x-callout.primary>
</x-filament.modal-content>
