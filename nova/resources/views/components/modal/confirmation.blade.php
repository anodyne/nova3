@props([
    'footer' => null,
    'icon' => null,
    'description' => null,
    'title',
])

@use('Illuminate\Support\Stringable')

@php
    $icon = isset($prompt['icon']) ? $prompt['icon'] : null;
    $message = str($prompt['message'])->markdown();
@endphp

<x-panel variant="well" class="flex h-full flex-col">
    <x-panel class="flex-1">
        <x-spacing size="md">
            <div class="flex flex-col gap-6">
                <div class="flex justify-between gap-6">
                    <div class="flex items-center gap-3">
                        @if ($icon)
                            <x-icon :name="$icon" size="lg" class="text-gray-500"></x-icon>
                        @endif

                        <x-h2>{{ $prompt['title'] }}</x-h2>
                    </div>

                    <div class="shrink-0">
                        <button
                            x-on:click="Livewire.dispatch('modal.close')"
                            alt="Close modal"
                            class="relative inline-flex h-8 w-8 items-center justify-center gap-2 whitespace-nowrap rounded-md bg-transparent text-sm font-medium text-gray-400 transition hover:bg-gray-800/5 hover:text-gray-800 dark:text-gray-500 dark:hover:bg-white/15 dark:hover:text-white"
                        >
                            <x-icon name="x" size="sm"></x-icon>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <div class="text-base/7">
                        {!! $message !!}
                    </div>

                    @if ($confirmPhrase)
                        <x-fieldset.field
                            :label="__('wire-elements-pro::modal.confirmation.please_enter_phrase_to_continue', ['phrase' => $confirmPhrase])"
                            id="confirm-phrase"
                            name="confirm-phrase"
                        >
                            <x-input.text wire:model.defer="confirmPhraseInput" required></x-input.text>
                        </x-fieldset.field>
                    @endif
                </div>
            </div>
        </x-spacing>
    </x-panel>

    <x-panel.footer class="flex items-center gap-x-4">
        <x-button wire:click="confirm" wire:loading.attr="disabled" :color="$theme ?? 'primary'">
            {{ $prompt['confirm'] }}
        </x-button>

        <x-button wire:click="$dispatch('modal.close')" wire:loading.attr="disabled" plain>
            {{ $prompt['cancel'] }}
        </x-button>
    </x-panel.footer>
</x-panel>
