@extends($meta->template)

@section('content')
    <x-page-header :title="$user->name">
        <x-slot:pretitle>
            <a href="{{ route('users.index', "status={$user->status->name()}") }}">Users</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel x-data="tabsList('details')">
        <div>
            <x-content-box class="sm:hidden">
                <select @change="switchTab($event.target.value)" aria-label="Selected tab" class="mt-1 form-select bg-white block w-full pl-3 pr-10 py-2 text-base border-gray-200 dark:border-gray-200/10 focus:outline-none focus:ring focus:border-blue-400 transition ease-in-out duration-200 sm:text-sm rounded-md">
                    <option value="details">Details</option>
                    <option value="characters">Characters</option>
                    <option value="roles">Roles</option>
                </select>
            </x-content-box>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200 dark:border-gray-200/10 px-4 sm:px-6">
                    <nav class="-mb-px flex">
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-400 text-blue-600': isTab('details'), 'text-gray-500 hover:text-gray-600 hover:border-gray-300': isNotTab('details') }" @click.prevent="switchTab('details')">
                            Details
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-400 text-blue-600': isTab('characters'), 'text-gray-500 hover:text-gray-600 hover:border-gray-300': isNotTab('characters') }" @click.prevent="switchTab('characters')">
                            Characters
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-400 text-blue-600': isTab('roles'), 'text-gray-500 hover:text-gray-600 hover:border-gray-300': isNotTab('roles') }" @click.prevent="switchTab('roles')">
                            Roles
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <x-form :action="route('users.update', $user)" method="PUT" x-show="isTab('details')">
            <x-form.section
                title="User Info"
                message="For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity."
                x-data="{ pronouns: '{{ old('pronouns.value', $user->pronouns->value) }}', pronounSubject: '{{ old('pronouns.subject', $user->pronouns->subject) }}', pronounObject: '{{ old('pronouns.object', $user->pronouns->object) }}', pronounPossessive: '{{ old('pronouns.possessive', $user->pronouns->possessive) }}' }"
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
                    <x-input.group label="What is your subject pronoun?" for="pronouns-subject" :error="$errors->first('pronouns.subject')">
                        <x-input.text id="pronouns-subject" name="pronouns[subject]" x-model="pronounSubject" placeholder="He, she, they, ze, etc." />
                    </x-input.group>

                    <x-input.group label="What is your object pronoun?" for="pronouns-object" :error="$errors->first('pronouns.object')">
                        <x-input.text id="pronouns-object" name="pronouns[object]" x-model="pronounObject" placeholder="Him, her, them, zir, etc." />
                    </x-input.group>

                    <x-input.group label="What is your possessive pronoun?" for="pronouns-possessive" :error="$errors->first('pronouns.possessive')">
                        <x-input.text id="pronouns-possessive" name="pronouns[possessive]" x-model="pronounPossessive" placeholder="His, hers, theirs, zirs, etc." />
                    </x-input.group>
                </div>
            </x-form.section>

            <x-form.section title="Avatar" message="User avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size.">
                <x-input.group>
                    @livewire('upload-avatar', ['existingAvatar' => $user->avatar_url])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Update User</x-button>
                <x-link :href='route("users.index", "status={$user->status->name()}")' color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>

        <div x-show="isTab('characters')" x-cloak>
            @livewire('users:manage-characters', ['user' => $user])
        </div>

        <div x-show="isTab('roles')" x-cloak>
            @livewire('users:manage-roles', ['user' => $user])
        </div>
    </x-panel>

    @can('deactivate', $user)
        <x-panel class="mt-8">
            <x-content-box>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Deactivate User
                </h3>
                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="w-full">
                        <p>
                            When deactivating the user, all characters associated with the user that are not jointly owned with another user will be deactivated as well.
                        </p>
                    </div>
                    <div class="mt-5 sm:mt-0 sm:ml-8 sm:shrink-0 sm:flex sm:items-center">
                        <x-form :action="route('users.deactivate', $user)">
                            <x-button type="submit" color="red-outline">
                                Deactivate
                            </x-button>
                        </x-form>
                    </div>
                </div>
            </x-content-box>
        </x-panel>
    @endcan

    @can('activate', $user)
        <x-panel class="mt-8">
            <x-content-box>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Activate User
                </h3>
                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="w-full">
                        <p>
                            When activating the user, their primary character will also be activated and their access roles will be set to the default roles for new users.
                        </p>
                    </div>
                    <div class="mt-5 sm:mt-0 sm:ml-8 sm:shrink-0 sm:flex sm:items-center">
                        <x-form :action="route('users.activate', $user)">
                            <x-button type="submit" color="blue-outline">
                                Activate
                            </x-button>
                        </x-form>
                    </div>
                </div>
            </x-content-box>
        </x-panel>
    @endcan

    <x-panel class="mt-8">
        <x-content-box>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Account Security
            </h3>

            @can('forcePasswordReset', $user)
                <div class="mt-6">
                    <x-panel as="light well">
                        <x-content-box>
                            <div class="sm:flex sm:items-start sm:justify-between">
                                <div class="sm:flex sm:items-start">
                                    @icon('lock', 'shrink-0 h-8 w-8 text-gray-400 dark:text-gray-500')
                                    <div class="mt-3 sm:mt-0 sm:ml-4">
                                        <div>
                                            If you believe this user should reset their password, you can force a password reset that will prompt them to change their password the next time they attempt to sign in.
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 sm:mt-0 sm:ml-6 sm:shrink-0">
                                    <x-form :action="route('users.force-password-reset', $user)">
                                        <x-button type="submit">
                                            Force Password Reset
                                        </x-button>
                                    </x-form>
                                </div>
                            </div>
                        </x-content-box>
                    </x-panel>
                </div>
            @endcan

            {{-- <div class="mt-6">
                <div class="rounded-md bg-gray-50 px-6 py-5 sm:flex sm:items-start sm:justify-between">
                    <div class="sm:flex sm:items-start">
                        @icon('sign-out', 'shrink-0 h-8 w-8 text-gray-500')
                        <div class="mt-3 sm:mt-0 sm:ml-4">
                            <div class="text-sm font-medium text-gray-600">
                                If necessary, you can sign a user out of their account. Be warned, if they're actively doing anything when you initiate this action, any work will be lost on their next page load.
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-6 sm:shrink-0">
                        <x-form :action="route('users.force-password-reset', $user)">
                            <span class="inline-flex rounded-md shadow-sm">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:ring active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-200">
                                    Sign This User Out
                                </button>
                            </span>
                        </x-form>
                    </div>
                </div>
            </div> --}}
        </x-content-box>
    </x-panel>
@endsection
