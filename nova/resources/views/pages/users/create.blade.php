@extends($meta->template)

@section('content')
    <x-page-header title="Add User">
        <x-slot name="pretitle">
            <a href="{{ route('users.index', 'status=active') }}">Users</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('users.store')">
            <x-form.section
                title="User Info"
                x-data="{ pronouns: '{{ old('pronouns.value', 'none') }}', pronounSubject: '{{ old('pronouns.subject', '') }}', pronounObject: '{{ old('pronouns.object', '') }}', pronounPossessive: '{{ old('pronouns.possessive', '') }}' }"
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
                <x-slot name="message">
                    <p>For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity.</p>

                    <p class="block"><strong class="font-semibold">Note:</strong> after the account is created, a password will be generated and emailed to the new user.</p>
                </x-slot>

                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Email address" for="email" :error="$errors->first('email')">
                    <x-input.email id="email" name="email" :value="old('email')" data-cy="email" />
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
                    @livewire('upload-avatar')
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Add User</x-button>
                <x-link :href="route('users.index', 'status=active')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
