@props([
    'name',
])

<button
    type="button"
    data-slot="tab"
    class="nv-tabs-tab"
    x-bind:data-active="isTab('{{ $name }}')"
    x-on:click="switchTab('{{ $name }}')"
    {{ $attributes }}
>
    {{ $slot }}
</button>
