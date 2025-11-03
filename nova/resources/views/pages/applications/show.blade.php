@use('Nova\Applications\Enums\ApplicationResult')
@use('Nova\Foundation\Helpers\DateHelper')

<x-admin-layout>
    <x-spacing>
        <x-page-heading>
            <x-slot name="heading">
                <div class="flex items-center gap-4">
                    <span>{{ $application->character->name }}</span>

                    <x-badge :color="$application->result->getColor()" size="md">
                        {{ $application->result->getLabel() }}
                    </x-badge>
                </div>
            </x-slot>

            <x-slot name="description">
                <x-metadata.group gap="md">
                    @if (filled($application->character->positions))
                        <x-metadata
                            label="Position"
                            :value="$application->character->positions->first()?->name"
                        ></x-metadata>
                    @endif

                    <x-metadata label="Applied" :value="$application->created_at->diffForHumans()"></x-metadata>
                </x-metadata.group>
            </x-slot>

            @can('viewAny', $application::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.applications.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <div class="grid gap-12 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-tab.group class="mb-12">
                    <x-slot name="tabs">
                        <x-tab name="application">
                            <x-icon :name="Tabler::Progress" size="sm" />
                            Application
                        </x-tab>

                        <x-tab name="review">
                            <x-icon :name="Tabler::Messages" size="sm" />
                            Review
                        </x-tab>

                        <x-tab name="history">
                            <x-icon :name="Tabler::History" size="sm" />
                            History
                        </x-tab>
                    </x-slot>

                    <x-tab.panel name="application" class="space-y-6">
                        {{-- User details --}}
                        <x-panel class="overflow-hidden" variant="well" x-data="{ expanded: true }" x-cloak>
                            <x-panel.header
                                title="User details"
                                :icon="Tabler::UserCircle"
                                class="cursor-pointer"
                                x-on:click="expanded = !expanded"
                            >
                                <x-slot name="badge">
                                    <x-badge :color="$application->user->status->getColor()" size="md">
                                        {{ $application->user->status->simple() }}
                                    </x-badge>
                                </x-slot>

                                <x-slot name="actions">
                                    <div
                                        class="shrink-0 text-gray-400 transition-transform duration-200 dark:text-gray-500"
                                        x-bind:class="{
                                            'rotate-90': expanded,
                                        }"
                                    >
                                        <x-icon :name="Tabler::ChevronRight" size="md" />
                                    </div>
                                </x-slot>
                            </x-panel.header>

                            <x-panel x-show="expanded" x-collapse x-cloak>
                                <x-spacing.group divided>
                                    <x-spacing size="md">
                                        <x-fieldset>
                                            <x-fieldset.group>
                                                <x-input.display label="Name">
                                                    <x-text>{{ $application->user->display_name }}</x-text>
                                                </x-input.display>

                                                <x-input.display label="Email address" copyable>
                                                    <x-text>{{ $application->user->email }}</x-text>
                                                </x-input.display>
                                            </x-fieldset.group>
                                        </x-fieldset>
                                    </x-spacing>

                                    @if ($userBioForm->has_published_fields)
                                        <x-spacing size="md">
                                            <livewire:dynamic-form
                                                :form="$userBioForm"
                                                :submission="$application->user->userFormSubmission"
                                                :admin="true"
                                                :static="true"
                                            />
                                        </x-spacing>
                                    @endif
                                </x-spacing.group>
                            </x-panel>
                        </x-panel>

                        {{-- Character details --}}
                        <x-panel class="overflow-hidden" variant="well" x-data="{ expanded: false }">
                            <x-panel.header
                                title="Character details"
                                :icon="Tabler::MasksTheater"
                                class="cursor-pointer"
                                x-on:click="expanded = !expanded"
                            >
                                <x-slot name="badge">
                                    <x-badge :color="$application->character->type->getColor()" size="md">
                                        {{ $application->character->type->getLabel() }}
                                    </x-badge>
                                </x-slot>

                                <x-slot name="actions">
                                    <div
                                        class="shrink-0 text-gray-400 transition-transform duration-200 dark:text-gray-500"
                                        x-bind:class="{
                                            'rotate-90': expanded,
                                        }"
                                    >
                                        <x-icon :name="Tabler::ChevronRight" size="md" />
                                    </div>
                                </x-slot>
                            </x-panel.header>

                            <x-panel x-show="expanded" x-collapse x-cloak>
                                <x-spacing.group divided>
                                    <x-spacing size="md">
                                        <x-fieldset>
                                            <x-fieldset.group>
                                                <x-input.display label="Character name">
                                                    <x-text>
                                                        {{ $application->character->name }}
                                                    </x-text>
                                                </x-input.display>

                                                @if (filled($application->character->positions))
                                                    <x-input.display label="Position">
                                                        <x-text>
                                                            {{ $application->character->positions->first()->name }}
                                                        </x-text>
                                                    </x-input.display>
                                                @endif
                                            </x-fieldset.group>
                                        </x-fieldset>
                                    </x-spacing>

                                    @if ($characterBioForm->has_published_fields)
                                        <x-spacing size="md">
                                            <livewire:dynamic-form
                                                :form="$characterBioForm"
                                                :submission="$application->character->characterFormSubmission"
                                                :admin="true"
                                                :static="true"
                                            />
                                        </x-spacing>
                                    @endif
                                </x-spacing.group>
                            </x-panel>
                        </x-panel>

                        {{-- Application details --}}
                        <x-panel class="overflow-hidden" variant="well" x-data="{ expanded: false }">
                            <x-panel.header
                                title="Application details"
                                :icon="Tabler::Progress"
                                class="cursor-pointer"
                                x-on:click="expanded = !expanded"
                            >
                                <x-slot name="actions">
                                    <div
                                        class="shrink-0 text-gray-400 transition-transform duration-200 dark:text-gray-500"
                                        x-bind:class="{
                                            'rotate-90': expanded,
                                        }"
                                    >
                                        <x-icon :name="Tabler::ChevronRight" size="md" />
                                    </div>
                                </x-slot>
                            </x-panel.header>

                            <x-panel x-show="expanded" x-collapse x-cloak>
                                <x-spacing.group divided>
                                    <x-spacing size="md">
                                        <x-fieldset>
                                            <x-fieldset.group>
                                                <x-input.display label="Application date">
                                                    <x-text>
                                                        {{ DateHelper::formatShortDateWithTime($application->created_at) }}
                                                    </x-text>
                                                </x-input.display>

                                                <x-input.display label="IP address" copyable>
                                                    <x-text class="tabular-nums">
                                                        {{ $application->ip_address ?? 'None available' }}
                                                    </x-text>
                                                </x-input.display>

                                                <x-input.display label="Status">
                                                    <x-badge :color="$application->result->getColor()" size="md">
                                                        {{ $application->result->getLabel() }}
                                                    </x-badge>
                                                </x-input.display>
                                            </x-fieldset.group>
                                        </x-fieldset>
                                    </x-spacing>

                                    @if ($applicationInfoForm->has_published_fields)
                                        <x-spacing size="md">
                                            <livewire:dynamic-form
                                                :form="$applicationInfoForm"
                                                :submission="$application->applicationFormSubmission"
                                                :admin="true"
                                                :static="true"
                                            />
                                        </x-spacing>
                                    @endif
                                </x-spacing.group>
                            </x-panel>
                        </x-panel>

                        {{-- Review details --}}
                        @if ($application->result !== ApplicationResult::Pending)
                            <x-panel variant="well" x-data="{ expanded: true }">
                                <x-panel.header
                                    title="Review details"
                                    :icon="$application->result === ApplicationResult::Accept ? Tabler::ProgressCheck : Tabler::ProgressX"
                                    class="cursor-pointer"
                                    x-on:click="expanded = !expanded"
                                >
                                    <x-slot name="actions">
                                        <div
                                            class="shrink-0 text-gray-400 transition-transform duration-200 dark:text-gray-500"
                                            x-bind:class="{
                                                'rotate-90': expanded,
                                            }"
                                        >
                                            <x-icon :name="Tabler::ChevronRight" size="md" />
                                        </div>
                                    </x-slot>
                                </x-panel.header>

                                <x-panel x-show="expanded" x-collapse x-cloak>
                                    <x-spacing.group divided>
                                        <x-spacing size="md">
                                            <x-fieldset>
                                                <x-fieldset.group>
                                                    <x-input.display label="Decision date">
                                                        <x-text>
                                                            {{ DateHelper::formatShortDateWithTime($application->decision_date) }}
                                                        </x-text>
                                                    </x-input.display>

                                                    <x-input.display label="Decision">
                                                        <x-badge :color="$application->result->getColor()" size="md">
                                                            {{ $application->result->getLabel() }}
                                                        </x-badge>
                                                    </x-input.display>
                                                </x-fieldset.group>
                                            </x-fieldset>
                                        </x-spacing>

                                        @if (settings('applications.showDecisionMessage'))
                                            <x-spacing size="md">
                                                <x-fieldset>
                                                    <x-fieldset.group>
                                                        <x-input.display label="Response message">
                                                            <x-text class="space-y-6">
                                                                {!! str($application->decision_message)->markdown() !!}
                                                            </x-text>
                                                        </x-input.display>
                                                    </x-fieldset.group>
                                                </x-fieldset>
                                            </x-spacing>
                                        @endif
                                    </x-spacing.group>
                                </x-panel>
                            </x-panel>
                        @endif
                    </x-tab.panel>

                    <x-tab.panel name="review">
                        <livewire:application-discussion :$application />
                    </x-tab.panel>

                    <x-tab.panel name="history">
                        <livewire:application-history :$application />
                    </x-tab.panel>
                </x-tab.group>
            </div>

            <div>
                <livewire:application-review :$application />
            </div>
        </div>
    </x-spacing>
</x-admin-layout>
