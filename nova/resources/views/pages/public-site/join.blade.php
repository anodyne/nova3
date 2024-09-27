@extends($meta->template)

@php
    $errors = $errors->getBag('default');
@endphp

@section('content')
    <div class="@container advanced-page join">
        <x-public::h1>{{ $meta->pageHeading }}</x-public::h1>

        @if (settings('applications.enabled'))
            @if (session()->has('join-submitted'))
                @if (session('join-submitted') === 'yes')
                    <x-public::alert level="success" title="Application received">
                        Your application has been received and will be reviewed by the staff.
                    </x-public::alert>
                @else
                    <x-public::alert level="danger" title="Application error">
                        There was an error submitting your application. Please contact a member of the game for more
                        information.
                    </x-public::alert>
                @endif
            @endif

            @if (filled($errors))
                <x-public::alert level="danger" title="Validation errors">
                    There are validation errors that require your attention in order to submit your application.
                </x-public::alert>
            @endif

            <x-form :action="route('public.join.process')">
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

                    <x-public::tabs.pane class="space-y-12" x-show="isTab('user')" x-cloak>
                        <div class="form-ctn">
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
                    </x-public::tabs.pane>

                    <x-public::tabs.pane class="space-y-12" x-show="isTab('character')" x-cloak>
                        <div class="form-ctn">
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
                                                @selected(old('characterInfo.position', $selectedPosition) == $position->id)
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
                    </x-public::tabs.pane>

                    @if ($applicationInfoForm->has_published_fields)
                        <x-public::tabs.pane x-show="isTab('application')" x-cloak>
                            <livewire:dynamic-form :form="$applicationInfoForm" :admin="false" />
                        </x-public::tabs.pane>
                    @endif
                </x-public::tabs>

                <div class="form-controls">
                    <x-public::button type="submit" primary>Submit</x-public::button>
                </div>
            </x-form>
        @else
            <x-public::alert level="warning" title="Applications closed">
                {{ settings('applications.disabledMessage') }}
            </x-public::alert>
        @endif
    </div>
@endsection
