<x-panel variant="well">
    <x-panel.header
        :title="$process->getLabel()"
        :description="$process->getDescription()"
        wire:key="{{ $process->value }}"
    >
        <x-slot name="actions">
            <x-progress.circular color="primary" :percentage="$percentComplete" size="lg"></x-progress.circular>
        </x-slot>
    </x-panel.header>

    <x-panel>
        <x-spacing.group class="grid grid-cols-[auto_1fr_auto]" divided>
            @foreach ($onboarder->steps() as $step)
                <x-spacing
                    size="row"
                    class="col-span-3 grid grid-cols-subgrid"
                    wire:key="onboarding-step-{{ $step->key() }}"
                >
                    <div class="mr-4 flex shrink-0">
                        <div class="flex h-8 items-center">
                            <x-checkbox wire:model.live="stepsData.{{ $step->key() }}"></x-checkbox>
                        </div>
                    </div>

                    <div class="col-start-2" x-data="{ expanded: false }">
                        <div class="flex items-center gap-4">
                            <x-h4 class="leading-8">{{ $step->label() }}</x-h4>

                            @if (! is_null($step->description()))
                                <flux:badge as="button" x-on:click="expanded = ! expanded" size="sm">
                                    More info
                                </flux:badge>
                            @endif
                        </div>

                        @if (! is_null($step->description()))
                            <div
                                class="mt-2 space-y-4 text-sm/6 font-normal text-gray-500"
                                x-show="expanded"
                                x-collapse
                                x-cloak
                            >
                                <p>{{ $step->description() }}</p>
                            </div>
                        @endif
                    </div>

                    @if (! is_null($step->linkUrl()))
                        <div class="col-start-3 ml-4 flex shrink-0 justify-end">
                            <div>
                                <x-button :href="$step->linkUrl()" size="sm">
                                    Go
                                    <span aria-hidden="true"><span aria-hidden="true">→</span></span>
                                </x-button>
                            </div>
                        </div>
                    @endif
                </x-spacing>
            @endforeach
        </x-spacing.group>
    </x-panel>

    <x-panel.footer>
        <x-dropdown class="max-w-80">
            <x-slot name="trigger">
                <x-button type="button" variant="subtle" inset="left top bottom">Finish onboarding process</x-button>
            </x-slot>

            <x-dropdown.group>
                @if ($percentComplete < 100)
                    <x-dropdown.text>
                        You have not completed all the steps of this checklist. Are you sure you want to complete this
                        onboarding checklist?
                    </x-dropdown.text>
                @else
                    <x-dropdown.text>Are you sure you want to complete this onboarding checklist?</x-dropdown.text>
                @endif
            </x-dropdown.group>

            <x-dropdown.group>
                <x-dropdown.item type="button" :icon="Tabler::Check" wire:click="finish">Finish</x-dropdown.item>
                <x-dropdown.item type="button" :icon="Tabler::Ban" x-on:click.prevent="$dispatch('dropdown-close')">
                    Cancel
                </x-dropdown.item>
            </x-dropdown.group>
        </x-dropdown>
    </x-panel.footer>
</x-panel>
