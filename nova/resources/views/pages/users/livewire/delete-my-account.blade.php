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
                            <x-icon name="user" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>User account</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon name="login" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Log in records</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon name="note" size="md"></x-icon>
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
                            <x-icon name="characters" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Characters</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon name="book" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Story posts</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon name="megaphone" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Announcements</x-h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-icon name="messages" size="md"></x-icon>
                        </div>
                        <div>
                            <x-h4>Direct messages</x-h4>
                        </div>
                    </div>
                </div>
            </div>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-dropdown placement="bottom-start">
            <x-slot name="emptyTrigger">
                <x-button color="danger">
                    <x-icon name="trash" size="sm"></x-icon>
                    Delete my account
                </x-button>
            </x-slot>

            <x-dropdown.group>
                <x-dropdown.text>
                    Are you sure you want to delete your account? This action is permanent and cannot be undone.
                </x-dropdown.text>
            </x-dropdown.group>
            <x-dropdown.group>
                <x-dropdown.item-danger type="button" icon="trash" wire:click="delete">Delete</x-dropdown.item-danger>
                <x-dropdown.item type="button" icon="prohibited" x-on:click.prevent="$dispatch('dropdown-close')">
                    Cancel
                </x-dropdown.item>
            </x-dropdown.group>
        </x-dropdown>
    </x-fieldset.controls>
</div>
