@extends($meta->template)

@use('Nova\Applications\Enums\ApplicationResult')

@section('content')
    <x-spacing>
        <x-page-header>
            <x-slot name="heading">
                <div class="flex items-center gap-x-4">
                    <span>{{ $application->character->name }}</span>
                    <x-badge :color="$application->result->color()">
                        {{ $application->result->getLabel() }}
                    </x-badge>
                </div>
            </x-slot>
            <x-slot name="description">
                <div class="flex items-center max-md:gap-y-4 lg:gap-x-6">
                    @if (filled($application->character->positions))
                        <div>{{ $application->character->positions->first()?->name }}</div>
                    @endif

                    <div>Applied {{ $application->created_at->diffForHumans() }}</div>
                </div>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $application::class)
                    <x-button :href="route('admin.applications.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <div class="grid gap-12 lg:grid-cols-3">
            <div class="lg:col-span-2" x-data="tabsList('app')">
                <x-tab.group name="app" class="mb-12">
                    <x-tab.heading name="app">
                        <x-icon name="write" size="sm"></x-icon>
                        Application
                    </x-tab.heading>
                    <x-tab.heading name="review">
                        <x-icon name="progress" size="sm"></x-icon>
                        Review
                    </x-tab.heading>
                </x-tab.group>

                <div class="space-y-6" x-show="isTab('app')" x-cloak>
                    {{-- User details --}}
                    <div x-data="{ expanded: true }" x-cloak>
                        <x-panel well>
                            <x-spacing size="sm">
                                <button
                                    type="button"
                                    class="flex w-full appearance-none items-center justify-between"
                                    x-on:click="expanded = !expanded"
                                >
                                    <div class="flex items-center space-x-1">
                                        <x-fieldset.legend>User details</x-fieldset.legend>
                                    </div>
                                    <div class="ml-8 flex shrink-0 items-center space-x-3">
                                        <x-badge :color="$application->user->status->color()">
                                            {{ $application->user->status->simple() }}
                                        </x-badge>

                                        <div x-show="!expanded">
                                            <x-icon
                                                name="add"
                                                size="md"
                                                class="text-gray-400 dark:text-gray-500"
                                            ></x-icon>
                                        </div>
                                        <div x-show="expanded">
                                            <x-icon
                                                name="remove"
                                                size="md"
                                                class="text-gray-400 dark:text-gray-500"
                                            ></x-icon>
                                        </div>
                                    </div>
                                </button>
                            </x-spacing>

                            <div x-show="expanded" x-collapse x-cloak>
                                <x-spacing size="2xs">
                                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                                        <x-spacing size="sm">
                                            <x-fieldset>
                                                <x-fieldset.field-group class="w-full">
                                                    <x-fieldset.field label="Name" id="user_name" name="user_name">
                                                        <x-text>{{ $application->user->name }}</x-text>
                                                    </x-fieldset.field>

                                                    <x-fieldset.field
                                                        label="Email address"
                                                        id="user_email"
                                                        name="user_email"
                                                    >
                                                        <x-text>{{ $application->user->email }}</x-text>
                                                    </x-fieldset.field>
                                                </x-fieldset.field-group>
                                            </x-fieldset>
                                        </x-spacing>

                                        @if ($userBioForm->has_published_fields)
                                            <x-spacing size="sm">
                                                <div>
                                                    <livewire:dynamic-form
                                                        :form="$userBioForm"
                                                        :submission="$application->user->userFormSubmission"
                                                        :admin="true"
                                                        :static="true"
                                                    />
                                                </div>
                                            </x-spacing>
                                        @endif
                                    </x-panel>
                                </x-spacing>
                            </div>
                        </x-panel>
                    </div>

                    {{-- Character details --}}
                    <div x-data="{ expanded: false }">
                        <x-panel well>
                            <x-spacing size="sm">
                                <button
                                    type="button"
                                    class="flex w-full appearance-none items-center justify-between"
                                    x-on:click="expanded = !expanded"
                                >
                                    <div class="flex items-center space-x-1">
                                        <x-fieldset.legend>Character details</x-fieldset.legend>
                                    </div>
                                    <div class="ml-8 flex shrink-0 items-center space-x-3">
                                        <x-badge :color="$application->character->type->color()">
                                            {{ $application->character->type->getLabel() }}
                                        </x-badge>

                                        <div x-show="!expanded">
                                            <x-icon
                                                name="add"
                                                size="md"
                                                class="text-gray-400 dark:text-gray-500"
                                            ></x-icon>
                                        </div>
                                        <div x-show="expanded">
                                            <x-icon
                                                name="remove"
                                                size="md"
                                                class="text-gray-400 dark:text-gray-500"
                                            ></x-icon>
                                        </div>
                                    </div>
                                </button>
                            </x-spacing>

                            <div x-show="expanded" x-collapse x-cloak>
                                <x-spacing size="2xs">
                                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                                        <x-spacing size="sm">
                                            <x-fieldset>
                                                <x-fieldset.field-group class="w-full max-w-md">
                                                    <x-fieldset.field
                                                        label="Character name"
                                                        id="character_name"
                                                        name="character_name"
                                                    >
                                                        <x-text>{{ $application->character->name }}</x-text>
                                                    </x-fieldset.field>

                                                    @if (filled($application->character->positions))
                                                        <x-fieldset.field
                                                            label="Position"
                                                            id="character_position"
                                                            name="character_position"
                                                        >
                                                            <x-text>
                                                                {{ $application->character->positions->first()->name }}
                                                            </x-text>
                                                        </x-fieldset.field>
                                                    @endif
                                                </x-fieldset.field-group>
                                            </x-fieldset>
                                        </x-spacing>

                                        @if ($characterBioForm->has_published_fields)
                                            <x-spacing size="sm">
                                                <livewire:dynamic-form
                                                    :form="$characterBioForm"
                                                    :submission="$application->character->characterFormSubmission"
                                                    :admin="true"
                                                    :static="true"
                                                />
                                            </x-spacing>
                                        @endif
                                    </x-panel>
                                </x-spacing>
                            </div>
                        </x-panel>
                    </div>

                    {{-- Application details --}}
                    <div x-data="{ expanded: false }">
                        <x-panel well>
                            <x-spacing size="sm">
                                <button
                                    type="button"
                                    class="flex w-full appearance-none items-center justify-between"
                                    x-on:click="expanded = !expanded"
                                >
                                    <div class="flex items-center space-x-1">
                                        <x-fieldset.legend>Application details</x-fieldset.legend>
                                    </div>
                                    <div class="ml-8 flex shrink-0 items-center space-x-3">
                                        <div x-show="!expanded">
                                            <x-icon
                                                name="add"
                                                size="md"
                                                class="text-gray-400 dark:text-gray-500"
                                            ></x-icon>
                                        </div>
                                        <div x-show="expanded">
                                            <x-icon
                                                name="remove"
                                                size="md"
                                                class="text-gray-400 dark:text-gray-500"
                                            ></x-icon>
                                        </div>
                                    </div>
                                </button>
                            </x-spacing>

                            <div x-show="expanded" x-collapse x-cloak>
                                <x-spacing size="2xs">
                                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                                        <x-spacing size="sm">
                                            <x-fieldset>
                                                <x-fieldset.field-group class="w-full max-w-md">
                                                    <x-fieldset.field
                                                        label="Application date"
                                                        id="app_date"
                                                        name="app_date"
                                                    >
                                                        <x-text>
                                                            {{ format_date($application->created_at) }}
                                                        </x-text>
                                                    </x-fieldset.field>

                                                    <x-fieldset.field label="IP address" id="app_ip" name="app_ip">
                                                        <x-text class="tabular-nums">
                                                            {{ $application->ip_address }}
                                                        </x-text>
                                                    </x-fieldset.field>

                                                    <x-fieldset.field label="Status" id="app_status" name="app_status">
                                                        <div data-slot="text">
                                                            <x-badge :color="$application->result->color()">
                                                                {{ $application->result->getLabel() }}
                                                            </x-badge>
                                                        </div>
                                                    </x-fieldset.field>
                                                </x-fieldset.field-group>
                                            </x-fieldset>
                                        </x-spacing>

                                        @if ($applicationInfoForm->has_published_fields)
                                            <x-spacing size="sm">
                                                <livewire:dynamic-form
                                                    :form="$applicationInfoForm"
                                                    :submission="$application->applicationFormSubmission"
                                                    :admin="true"
                                                    :static="true"
                                                />
                                            </x-spacing>
                                        @endif
                                    </x-panel>
                                </x-spacing>
                            </div>
                        </x-panel>
                    </div>

                    {{-- Review details --}}
                    @if ($application->result !== ApplicationResult::Pending)
                        <div x-data="{ expanded: true }">
                            <x-panel well>
                                <x-spacing size="sm">
                                    <button
                                        type="button"
                                        class="flex w-full appearance-none items-center justify-between"
                                        x-on:click="expanded = !expanded"
                                    >
                                        <div class="flex items-center space-x-1">
                                            <x-fieldset.legend>Review details</x-fieldset.legend>
                                        </div>
                                        <div class="ml-8 flex shrink-0 items-center space-x-3">
                                            <div x-show="!expanded">
                                                <x-icon
                                                    name="add"
                                                    size="md"
                                                    class="text-gray-400 dark:text-gray-500"
                                                ></x-icon>
                                            </div>
                                            <div x-show="expanded">
                                                <x-icon
                                                    name="remove"
                                                    size="md"
                                                    class="text-gray-400 dark:text-gray-500"
                                                ></x-icon>
                                            </div>
                                        </div>
                                    </button>
                                </x-spacing>

                                <div x-show="expanded" x-collapse x-cloak>
                                    <x-spacing size="2xs">
                                        <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                                            <x-spacing size="sm">
                                                <x-fieldset>
                                                    <x-fieldset.field-group>
                                                        <x-fieldset.field
                                                            label="Decision date"
                                                            id="result_date"
                                                            name="result_date"
                                                        >
                                                            <x-text>
                                                                {{ format_date($application->decision_date) }}
                                                            </x-text>
                                                        </x-fieldset.field>

                                                        <x-fieldset.field
                                                            label="Decision"
                                                            id="result_decision"
                                                            name="result_decision"
                                                        >
                                                            <div data-slot="text">
                                                                <x-badge :color="$application->result->color()">
                                                                    {{ $application->result->getLabel() }}
                                                                </x-badge>
                                                            </div>
                                                        </x-fieldset.field>
                                                    </x-fieldset.field-group>
                                                </x-fieldset>
                                            </x-spacing>

                                            @if (settings('applications.showDecisionMessage'))
                                                <x-spacing size="sm">
                                                    <x-fieldset>
                                                        <x-fieldset.field-group>
                                                            <x-fieldset.field
                                                                label="Response message"
                                                                id="result_message"
                                                                name="result_message"
                                                            >
                                                                <x-text tag="div" class="space-y-6">
                                                                    {!! str($application->decision_message)->markdown() !!}
                                                                </x-text>
                                                            </x-fieldset.field>
                                                        </x-fieldset.field-group>
                                                    </x-fieldset>
                                                </x-spacing>
                                            @endif
                                        </x-panel>
                                    </x-spacing>
                                </div>
                            </x-panel>
                        </div>
                    @endif
                </div>

                <div x-show="isTab('review')" x-cloak>
                    <livewire:application-discussion :$application />
                </div>
            </div>

            <div>
                <livewire:application-review :$application />
            </div>
        </div>
    </x-spacing>
@endsection
