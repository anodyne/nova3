<div class="space-y-12" wire:key="delete-account">
    <x-text variant="strong">
        This will delete your account and you will no longer be able to interact with the game.
    </x-text>

    <x-fieldset>
        <x-fieldset.group>
            <div>
                <x-text>The following information will be deleted:</x-text>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::User" size="md" />
                        </div>
                        <div>
                            <x-h4>User account</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::Login" size="md" />
                        </div>
                        <div>
                            <x-h4>Log in records</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::Note" size="md" />
                        </div>
                        <div>
                            <x-h4>Notes</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::Speakerphone" size="md" />
                        </div>
                        <div>
                            <x-h4>Draft &amp; pending announcements</x-h4>
                        </div>
                    </div>
                </div>

                <x-text class="mt-8">The following information will not be deleted:</x-text>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::Progress" size="md" />
                        </div>
                        <div>
                            <x-h4>Application(s)</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::MasksTheater" size="md" />
                        </div>
                        <div>
                            <x-h4>Characters</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::Forms" size="md" />
                        </div>
                        <div>
                            <x-h4>Form responses</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::Book2" size="md" />
                        </div>
                        <div>
                            <x-h4>Story posts</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::Speakerphone" size="md" />
                        </div>
                        <div>
                            <x-h4>Published announcements</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Tabler::Inbox" size="md" />
                        </div>
                        <div>
                            <x-h4>Messages</x-h4>
                        </div>
                    </div>
                </div>
            </div>
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-dropdown placement="bottom start" class="w-56">
            <x-slot name="trigger">
                <x-button type="button" variant="danger">
                    <x-icon :name="Tabler::Trash" size="sm" />
                    Delete my account
                </x-button>
            </x-slot>

            <x-dropdown.group>
                <x-dropdown.text>
                    Are you sure you want to delete your account? This action is permanent and cannot be undone.
                </x-dropdown.text>
            </x-dropdown.group>
            <x-dropdown.group>
                <x-dropdown.item type="button" :icon="Tabler::Trash" wire:click="delete" variant="danger">
                    Delete
                </x-dropdown.item>
                <x-dropdown.item type="button" :icon="Tabler::Ban" x-on:click.prevent="$dispatch('dropdown-close')">
                    Cancel
                </x-dropdown.item>
            </x-dropdown.group>
        </x-dropdown>
    </x-fieldset.controls>
</div>
