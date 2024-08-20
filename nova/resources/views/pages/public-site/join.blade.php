@extends($meta->template)

@php
    $errors = $errors->getBag('default');
@endphp

@section('content')
    <div class="@container nova-advanced-page-content">
        <x-public::h1>Join</x-public::h1>

        @if (settings('applications.enabled'))
            @if (session()->has('join-submitted'))
                <x-public::alert level="success" title="Application received" class="mt-8">
                    Your application has been received and will be reviewed by the staff.
                </x-public::alert>
            @endif

            @if (filled($errors))
                <x-public::alert level="danger" title="Validation errors" class="mt-8">
                    There are validation errors that require your attention in order to submit your application.
                </x-public::alert>
            @endif

            <x-form :action="route('join.process')">
                <x-public::tabs class="mt-8" initial="user">
                    <x-slot name="tabs">
                        <x-public::tabs.tab name="user">
                            <div class="flex items-center gap-x-2">
                                <span>User info</span>

                                @if ($errors->has('userInfo.*') || $errors->has('userBio.*'))
                                    <span class="text-danger-500">
                                        <x-icon name="alert" size="sm"></x-icon>
                                    </span>
                                @endif
                            </div>
                        </x-public::tabs.tab>

                        @if ($characterBioForm->has_published_fields)
                            <x-public::tabs.tab name="character">
                                <div class="flex items-center gap-x-2">
                                    <span>Character info</span>

                                    @if ($errors->has('characterInfo.*') || $errors->has('characterBio.*'))
                                        <span class="text-danger-500">
                                            <x-icon name="alert" size="sm"></x-icon>
                                        </span>
                                    @endif
                                </div>
                            </x-public::tabs.tab>
                        @endif

                        @if ($applicationInfoForm->has_published_fields)
                            <x-public::tabs.tab name="application">
                                <div class="flex items-center gap-x-2">
                                    <span>Application info</span>

                                    @if ($errors->has('applicationInfo.*'))
                                        <span class="text-danger-500">
                                            <x-icon name="alert" size="sm"></x-icon>
                                        </span>
                                    @endif
                                </div>
                            </x-public::tabs.tab>
                        @endif
                    </x-slot>

                    <div class="mt-8 w-full space-y-12" x-show="isTab('user')" x-cloak>
                        <div class="max-w-2xl space-y-8">
                            <x-public::field.text
                                name="userInfo[name]"
                                label="Name"
                                id="user_name"
                                :error="$errors->first('userInfo.name')"
                                value="{{ old('userInfo.name') }}"
                            ></x-public::field.text>

                            <x-public::field.email
                                name="userInfo[email]"
                                label="Email address"
                                id="user_email"
                                :error="$errors->first('userInfo.email')"
                                value="{{ old('userInfo.email') }}"
                            ></x-public::field.email>

                            <x-public::field.password
                                name="userInfo[password]"
                                label="Password"
                                id="user_password"
                                :error="$errors->first('userInfo.password')"
                            ></x-public::field.password>
                        </div>

                        @if ($userBioForm->has_published_fields)
                            <livewire:dynamic-form :form="$userBioForm" :admin="false" />
                        @endif
                    </div>

                    <div class="mt-8 w-full space-y-12" x-show="isTab('character')" x-cloak>
                        <div class="max-w-2xl space-y-8">
                            <x-public::field.text
                                name="characterInfo[name]"
                                label="Character name"
                                id="character_name"
                                :error="$errors->first('characterInfo.name')"
                                value="{{ old('characterInfo.name') }}"
                            ></x-public::field.text>

                            <x-public::field.select
                                name="characterInfo[position]"
                                label="Position"
                                id="character_position"
                            >
                                @foreach ($departments as $department)
                                    <optgroup label="{{ $department->name }}">
                                        @foreach ($department->positions as $position)
                                            <option
                                                value="{{ $position->id }}"
                                                @selected(old('characterInfo.position') == $position->id)
                                            >
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </x-public::field.select>
                        </div>

                        @if ($characterBioForm->has_published_fields)
                            <livewire:dynamic-form :form="$characterBioForm" :admin="false" />
                        @endif
                    </div>

                    @if ($applicationInfoForm->has_published_fields)
                        <div class="mt-8 w-full" x-show="isTab('application')" x-cloak>
                            <livewire:dynamic-form :form="$applicationInfoForm" :admin="false" />
                        </div>
                    @endif
                </x-public::tabs>

                <div class="mt-8 w-full">
                    <x-public::button type="submit" primary>Submit</x-public::button>
                </div>
            </x-form>
        @else
            <x-public::alert level="warning" title="Applications closed" class="mt-8">
                {{ settings('applications.disabledMessage') }}
            </x-public::alert>
        @endif
    </div>
@endsection
