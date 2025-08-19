<x-button
    x-data="{ copied: false }"
    x-on:click="copied = ! copied; navigator.clipboard && navigator.clipboard.writeText($el.previousElementSibling?.innerText || ''); setTimeout(() => copied = false, 2000)"
    x-bind:data-copyable-copied="copied"
    aria-label="{{ __('Copy to clipboard') }}"
    variant="subtle"
    square
    {{ $attributes }}
>
    <x-icon :name="Tabler::Copy" size="sm" class="block [[data-copyable-copied]>&]:hidden" />
    <x-icon :name="Tabler::CopyCheck" size="sm" class="text-primary-500 hidden [[data-copyable-copied]>&]:block" />
</x-button>
