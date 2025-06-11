@php
    $errors = $errors->getBag('default');
@endphp

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                <x-button :href="route('admin.users.index')" plain>&larr; Back</x-button>
            </x-slot>
        </x-page-header>

        <div
            x-data="{
                pronouns: '{{ old('pronouns.value', $user->pronouns->value) }}',
                pronounSubject: '{{ old('pronouns.subject', $user->pronouns->subject) }}',
                pronounObject: '{{ old('pronouns.object', $user->pronouns->object) }}',
                ...tabsList(
                    '{{ $errors->has('userBio.*') && ! $errors->hasAny(['name', 'email', 'pronouns']) ? 'bio' : 'info' }}',
                ),
            }"
            x-init="
                $watch('pronouns', (value, oldValue) => {
                    if (value !== oldValue) {
                        pronounSubject = ''
                        pronounObject = ''
                    }
                })
            "
        >
            <x-form :action="route('admin.users.update', $user)" method="PUT">
                @if (filled($form->published_fields))
                    <x-tab.group name="user">
                        <x-tab.heading name="info">
                            <x-icon name="info" size="sm"></x-icon>
                            Basic info
                            @if ($errors->hasAny(['email', 'name', 'pronouns']))
                                <span class="shrink-0 text-danger-500">
                                    <x-icon.micro.alert />
                                </span>
                            @endif
                        </x-tab.heading>
                        <x-tab.heading name="bio">
                            <x-icon name="user-profile" size="sm"></x-icon>
                            Bio
                            @if ($errors->has('userBio.*'))
                                <span class="shrink-0 text-danger-500">
                                    <x-icon.micro.alert />
                                </span>
                            @endif
                        </x-tab.heading>
                    </x-tab.group>
                @endif

                <div class="space-y-12" x-show="isTab('info')">
                    <x-fieldset>
                        <x-fieldset.field-group constrained>
                            <x-fieldset.field
                                label="Name"
                                description="For privacy reasons, consider using a nickname rather than a user’s real name."
                                id="name"
                                name="name"
                                :error="$errors->first('name')"
                            >
                                <x-input.text :value="old('name', $user->name)" data-cy="name" />
                            </x-fieldset.field>

                            <x-fieldset.field
                                label="Email address"
                                id="email"
                                name="email"
                                :error="$errors->first('email')"
                            >
                                <x-input.email :value="old('email', $user->email)" data-cy="email" />
                            </x-fieldset.field>

                            <x-fieldset.field
                                label="Password"
                                description="Only users can update their current password. If a user is unable to sign in, they can use the reset password page or an admin can force a password reset."
                                id="password"
                                name="password"
                            ></x-fieldset.field>

                            <x-fieldset.field
                                label="Pronouns"
                                id="pronouns"
                                name="pronouns[value]"
                                :error="$errors->first('pronouns.value')"
                            >
                                <x-select class="w-auto" x-model="pronouns">
                                    <option value="none">Prefer not to share</option>
                                    <option value="male">He/Him</option>
                                    <option value="female">She/Her</option>
                                    <option value="neutral">They/Them</option>
                                    <option value="other">Other pronouns not listed (please specify)</option>
                                </x-select>
                            </x-fieldset.field>

                            <div x-show="pronouns === 'other'" class="space-y-6" x-cloak>
                                <x-fieldset.field
                                    label="What is your subject pronoun?"
                                    id="pronouns_subject"
                                    name="pronouns[subject]"
                                    :error="$errors->first('pronouns.subject')"
                                >
                                    <x-input.text x-model="pronounSubject" placeholder="He, she, they, ze, etc." />
                                </x-fieldset.field>

                                <x-fieldset.field
                                    label="What is your object pronoun?"
                                    id="pronouns_object"
                                    name="pronouns[object]"
                                    :error="$errors->first('pronouns.object')"
                                >
                                    <x-input.text x-model="pronounObject" placeholder="Him, her, them, zir, etc." />
                                </x-fieldset.field>
                            </div>

                            <x-fieldset.field label="User photo" id="avatar" name="avatar">
                                <livewire:media-upload-avatar :model="$user" />
                            </x-fieldset.field>
                        </x-fieldset.field-group>
                    </x-fieldset>

                    <x-fieldset>
                        <x-panel variant="well">
                            <x-panel.header
                                title="Characters assigned to this user"
                                description="Users can be assigned as many characters as you want."
                            ></x-panel.header>

                            <livewire:users-manage-characters :user="$user" />
                        </x-panel>
                    </x-fieldset>

                    <x-fieldset>
                        <x-panel variant="well">
                            <x-panel.header
                                title="Roles assigned to this user"
                                description="Roles control what users can do inside of Nova. You can assign as many roles as needed to users"
                            ></x-panel.header>

                            <livewire:users-manage-roles :user="$user" />
                        </x-panel>
                    </x-fieldset>

                    <x-fieldset>
                        <x-panel variant="well">
                            <x-panel.header
                                title="Moderation"
                                description="You can require approval for publishing certain pieces of content"
                            ></x-panel.header>

                            <x-panel class="grid grid-cols-[1fr_auto] divide-y divide-gray-950/5 dark:divide-white/10">
                                <x-spacing class="col-span-2 grid grid-cols-subgrid items-start" size="row">
                                    <div>
                                        <x-h4>Announcements</x-h4>
                                        <x-text>Require approval for this user to publish an announcement</x-text>
                                    </div>
                                    <div class="ml-8 flex shrink-0 justify-end">
                                        <x-switch
                                            name="moderations[announcements]"
                                            :value="old('moderations[announcements]', $user->moderations?->announcements ?? false)"
                                            id="moderations_announcements"
                                        ></x-switch>
                                    </div>
                                </x-spacing>

                                <x-spacing class="col-span-2 grid grid-cols-subgrid items-start" size="row">
                                    <div>
                                        <x-h4>Posts</x-h4>
                                        <x-text>
                                            Require approval for this user to publish a post. This approval will be
                                            required whether they are the only author or writing with other players.
                                        </x-text>
                                    </div>
                                    <div class="ml-8 flex shrink-0 justify-end">
                                        <x-switch
                                            name="moderations[posts]"
                                            :value="old('moderations[posts]', $user->moderations?->posts ?? false)"
                                            id="moderations_posts"
                                        ></x-switch>
                                    </div>
                                </x-spacing>
                            </x-panel>
                        </x-panel>
                    </x-fieldset>

                    @canany(['activate', 'deactivate', 'forcePasswordReset'], $user)
                        <x-fieldset>
                            <x-panel variant="well">
                                <x-panel.header title="Administrative actions"></x-panel.header>

                                <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                                    @can('activate', $user)
                                        <x-spacing size="md" class="grid grid-cols-3 gap-6">
                                            <div class="col-span-2">
                                                <div class="flex items-center gap-2">
                                                    <x-icon name="check" size="md" class="text-gray-500"></x-icon>
                                                    <x-h3>Activate character</x-h3>
                                                </div>
                                                <x-text class="mt-2">
                                                    When activating the user, their primary character will also be
                                                    activated and their access roles will be set to the default roles
                                                    for new users.
                                                </x-text>
                                            </div>
                                            <div class="flex items-start justify-end">
                                                <livewire:users-activate-button :user="$user" />
                                            </div>
                                        </x-spacing>
                                    @endcan

                                    @can('deactivate', $user)
                                        <x-spacing size="md" class="grid grid-cols-3 gap-6">
                                            <div class="col-span-2">
                                                <div class="flex items-center gap-2">
                                                    <x-icon name="remove" size="md" class="text-gray-500"></x-icon>
                                                    <x-h3>Deactivate user</x-h3>
                                                </div>
                                                <x-text class="mt-2">
                                                    When deactivating this user, all characters associated with their
                                                    account that are not jointly owned with another user will be
                                                    deactivated as well.
                                                </x-text>
                                            </div>
                                            <div class="flex items-start justify-end">
                                                <livewire:users-deactivate-button :user="$user" />
                                            </div>
                                        </x-spacing>
                                    @endcan

                                    @can('forcePasswordReset', $user)
                                        <x-spacing size="md" class="grid grid-cols-3 gap-6">
                                            <div class="col-span-2">
                                                <div class="flex items-center gap-2">
                                                    <x-icon name="lock-closed" size="md" class="text-gray-500"></x-icon>
                                                    <x-h3>Force password reset</x-h3>
                                                </div>
                                                <x-text class="mt-2">
                                                    If you believe this user should reset their password, you can force
                                                    a password reset that will prompt them to change their password the
                                                    next time they sign in.
                                                </x-text>
                                            </div>
                                            <div class="flex items-start justify-end">
                                                <livewire:users-force-password-reset-button :user="$user" />
                                            </div>
                                        </x-spacing>
                                    @endcan
                                </x-panel>
                            </x-panel>
                        </x-fieldset>
                    @endcanany
                </div>

                <div class="w-full max-w-md" x-show="isTab('bio')">
                    <livewire:dynamic-form
                        :form="$form"
                        :submission="$user->userFormSubmission"
                        :owner="$user"
                        :admin="true"
                    />
                </div>

                <x-fieldset.controls>
                    <x-button type="submit" color="primary">Update</x-button>
                    <x-button :href="route('admin.users.index')" plain>Cancel</x-button>
                </x-fieldset.controls>
            </x-form>
        </div>
    </x-spacing>
</x-admin-layout>
