<div class="relative rounded-md shadow-sm">
    <input
        type="text"
        name="{{ $key }}"
        id="{{ $key }}"
        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-8 sm:text-sm border-gray-300 rounded-md"
        placeholder="Filter..."
        wire:model="value"
    >

    @if ($value !== $initialValue)
        <div class="absolute inset-y-0 right-2 flex items-center">
            <button type="button" class="text-gray-400 hover:text-gray-500" wire:click="resetValue">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                <span class="sr-only">Reset</span>
            </button>
        </div>
    @endif
</div>