@use('Illuminate\Support\Js')

<button
    type="button"
    wire:click="openForEditing"
    class="flex items-center gap-x-3 rounded-lg px-3 py-2 hover:bg-gray-950/5"
>
    <x-rating.compact label="L" :value="$language"></x-rating.compact>
    <x-rating.compact label="S" :value="$sex"></x-rating.compact>
    <x-rating.compact label="V" :value="$violence"></x-rating.compact>
</button>
