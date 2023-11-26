@extends($meta->template)

@section('content')
    <x-panel class="overflow-hidden" x-data="tabsList('info')">
        <x-panel.header title="My account">
            <div>
                <x-content-box class="sm:hidden">
                    <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                        <option value="info">User info</option>
                        <option value="notifications">Notifications</option>
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
                        </nav>
                    </x-content-box>
                </div>
            </div>
        </x-panel.header>

        <x-form :action="route('account.update')" :divide="false" :space="false">
            <div x-show="isTab('info')" class="divide-y divide-gray-100 dark:divide-gray-800">
                <x-form.section
                    title="User info"
                    message="For privacy reasons, we don't recommend using your real name. Instead, use a nickname to help protect your identity."
                    x-data="{
                        pronouns: '{{ old('pronouns.value', $user->pronouns->value) }}',
                        pronounSubject: '{{ old('pronouns.subject', $user->pronouns->subject) }}',
                        pronounObject: '{{ old('pronouns.object', $user->pronouns->object) }}',
                        pronounPossessive: '{{ old('pronouns.possessive', $user->pronouns->possessive) }}'
                    }"
                    x-init="
                        $watch('pronouns', (value, oldValue) => {
                            if (value !== oldValue) {
                                pronounSubject = '';
                                pronounObject = '';
                                pronounPossessive = '';
                            }
                        })
                    "
                >
                    <x-input.group label="Name" for="name" :error="$errors->first('name')">
                        <x-input.text id="name" name="name" :value="old('name', $user->name)" data-cy="name" />
                    </x-input.group>

                    <x-input.group label="Email address" for="email" :error="$errors->first('email')">
                        <x-input.email id="email" name="email" :value="old('email', $user->email)" data-cy="email" />
                    </x-input.group>

                    <x-input.group label="Pronouns" for="pronouns" :error="$errors->first('pronouns.value')">
                        <x-input.select name="pronouns[value]" id="pronouns" class="w-auto" x-model="pronouns">
                            <option value="none">Prefer not to share</option>
                            <option value="male">He/Him/His</option>
                            <option value="female">She/Her/Hers</option>
                            <option value="neutral">They/Them/Theirs</option>
                            <option value="neo">Ze/Zir/Zirs</option>
                            <option value="other">Other pronouns not listed (please specify)</option>
                        </x-input.select>
                    </x-input.group>

                    <div x-show="pronouns === 'other'" class="space-y-6" x-cloak>
                        <x-input.group
                            label="What is your subject pronoun?"
                            for="pronouns-subject"
                            :error="$errors->first('pronouns.subject')"
                        >
                            <x-input.text
                                id="pronouns-subject"
                                name="pronouns[subject]"
                                x-model="pronounSubject"
                                placeholder="He, she, they, ze, etc."
                            />
                        </x-input.group>

                        <x-input.group
                            label="What is your object pronoun?"
                            for="pronouns-object"
                            :error="$errors->first('pronouns.object')"
                        >
                            <x-input.text
                                id="pronouns-object"
                                name="pronouns[object]"
                                x-model="pronounObject"
                                placeholder="Him, her, them, zir, etc."
                            />
                        </x-input.group>

                        <x-input.group
                            label="What is your possessive pronoun?"
                            for="pronouns-possessive"
                            :error="$errors->first('pronouns.possessive')"
                        >
                            <x-input.text
                                id="pronouns-possessive"
                                name="pronouns[possessive]"
                                x-model="pronounPossessive"
                                placeholder="His, hers, theirs, zirs, etc."
                            />
                        </x-input.group>
                    </div>
                </x-form.section>

                <x-form.section title="Password">
                    <x-input.group label="New password">
                        <x-input.password name="password"></x-input.password>
                    </x-input.group>

                    <x-input.group label="Confirm new password">
                        <x-input.password name="confirm_password"></x-input.password>
                    </x-input.group>
                </x-form.section>

                <x-form.section
                    title="Avatar"
                    message="User avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size."
                >
                    <x-input.group>
                        @livewire('media:upload-avatar', ['existingAvatar' => $user->avatar_url])
                    </x-input.group>
                </x-form.section>

                <x-form.section title="Delete account">
                    <x-panel>
                        <div class="divide-y divide-gray-200 dark:divide-gray-800">
                            <x-content-box height="sm" class="grid grid-cols-3 gap-6">
                                <div class="col-span-2">
                                    <div class="flex items-center gap-2">
                                        <x-icon name="trash" size="md" class="text-gray-500"></x-icon>
                                        <x-h3>Delete my account</x-h3>
                                    </div>
                                    <p class="mt-2 text-sm/6 text-gray-600 dark:text-gray-400">
                                        This will delete your account and you will no longer be able to interact with
                                        the game.
                                    </p>

                                    <p class="mt-4 text-sm/6 text-gray-600 dark:text-gray-400">
                                        The following information will be deleted:
                                    </p>
                                    <div class="mt-2 grid grid-cols-2 gap-4">
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

                                    <p class="mt-8 text-sm/6 text-gray-600 dark:text-gray-400">
                                        The following information will not be deleted:
                                    </p>
                                    <div class="mt-2 grid grid-cols-2 gap-4">
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
                                <div class="flex items-start justify-end">
                                    <livewire:users-delete-account-button :user="$user" />
                                </div>
                            </x-content-box>
                        </div>
                    </x-panel>
                </x-form.section>
            </div>

            <div x-show="isTab('notifications')" x-cloak>
                <livewire:profile-notification-preferences />
            </div>

            <x-form.footer x-show="isTab('info')">
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
