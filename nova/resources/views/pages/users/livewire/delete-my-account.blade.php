<div class="space-y-12" wire:key="delete-account">
    <x-fieldset>
        <x-fieldset.legend>Delete account</x-fieldset.legend>
        <x-fieldset.description>
            This will delete your account and you will no longer be able to interact with the game.
        </x-fieldset.description>

        <x-fieldset.field-group>
            <div>
                <x-text>The following information will be deleted:</x-text>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Icon::User" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>User account</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Icon::Login" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Log in records</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Icon::Note" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Notes</x-h4>
                        </div>
                    </div>
                </div>

                <x-text class="mt-8">The following information will not be deleted:</x-text>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Icon::Progress" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Application(s)</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Icon::Characters" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Characters</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Icon::Form" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Form responses</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Icon::BookClosed" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Story posts</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Icon::Megaphone" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Announcements</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon :name="Icon::Inbox" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Messages</x-h4>
                        </div>
                    </div>
                </div>
            </div>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-dropdown placement="bottom start" class="w-56">
            <x-slot name="trigger">
                <x-button type="button" color="danger">
                    <x-icon :name="Icon::Trash" size="sm"></x-icon>
                    Delete my account
                </x-button>
            </x-slot>

            <x-dropdown.group>
                <x-dropdown.text>
                    Are you sure you want to delete your account? This action is permanent and cannot be undone.
                </x-dropdown.text>
            </x-dropdown.group>
            <x-dropdown.group>
                <x-dropdown.item type="button" :icon="Icon::Trash" wire:click="delete" variant="danger">
                    Delete
                </x-dropdown.item>
                <x-dropdown.item type="button" :icon="Icon::Ban" x-on:click.prevent="$dispatch('dropdown-close')">
                    Cancel
                </x-dropdown.item>
            </x-dropdown.group>
        </x-dropdown>
    </x-fieldset.controls>
</div>
