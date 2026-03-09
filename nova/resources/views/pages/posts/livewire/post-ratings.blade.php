<button
    type="button"
    wire:click="openForEditing"
    class="flex items-center gap-3 rounded-xl p-1 hover:bg-gray-950/10 dark:hover:bg-white/10"
>
    <x-rating.compact label="L" :value="$language"></x-rating.compact>
    <x-rating.compact label="S" :value="$sex"></x-rating.compact>
    <x-rating.compact label="V" :value="$violence"></x-rating.compact>
</button>
