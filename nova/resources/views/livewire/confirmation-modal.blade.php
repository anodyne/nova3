@php
    $message = str($prompt['message'])->markdown();
@endphp

<x-modal
    :size-class="$this->sizeClass()"
    :title="$prompt['title']"
    :icon="$prompt['icon'] ?? null"
    :color="$theme"
>
    <div class="text-base/7">
        {!! $message !!}
    </div>

    @if ($confirmPhrase)
        <x-input
            :label="'Please enter &quot;' . $confirmPhrase . '&quot; to continue.'"
            wire:model.defer="confirmPhraseInput"
            name="confirm-phrase"
            required
        />
    @endif

    <x-slot name="footer">
        <x-button wire:click="confirm" wire:loading.attr="disabled" :color="$theme">
            {{ $prompt['confirm'] }}
        </x-button>

        <x-button x-modal:close wire:loading.attr="disabled" variant="ghost">
            {{ $prompt['cancel'] }}
        </x-button>
    </x-slot>
</x-modal>
