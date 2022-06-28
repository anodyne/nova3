<x-write-post-wizard-layout :steps="$steps">
    <x-content-box>
        Publish post
    </x-content-box>

    <x-content-box height="sm" class="flex flex-col space-y-4 rounded-b-lg border-t border-gray-200 dark:border-gray-200/10 md:flex-row-reverse md:items-center md:space-y-0 md:space-x-6 md:space-x-reverse justify-between">
        <div class="flex flex-col md:flex-row-reverse md:items-center md:space-x-reverse space-y-4 md:space-y-0 md:space-x-6">
            <x-button wire:click="nextStep" color="primary">Publish</x-button>

            <x-button wire:click="save" color="white">
                Save
            </x-button>
        </div>

        {{-- @can('delete', $post) --}}
            <div>
                <x-link href="#" color="gray-error-text" size="none">Discard draft</x-link>
            </div>
        {{-- @endcan --}}
    </x-content-box>
</x-write-post-wizard-layout>
