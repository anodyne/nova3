<label for="darkmode" class="flex items-center">
    <button id="darkmode" type="button" class="{{ $appearance === 'dark' ? 'bg-blue-9' : 'bg-gray-6' }} relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-1 focus:ring-blue-7" role="switch" aria-checked="false" wire:click="toggle()">
        <span class="sr-only">Use setting</span>

        <span class="{{ $appearance === 'dark' ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none relative inline-block h-5 w-5 rounded-full bg-gray-1 shadow transform ring-0 transition ease-in-out duration-200">
            <span class="{{ $appearance === 'light' ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100' }} absolute inset-0 h-full w-full flex items-center justify-center transition-opacity" aria-hidden="true">
                <x-icon.sun class="h-4 w-4 text-yellow-9" />
            </span>

            <span class="{{ $appearance === 'dark' ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100' }} absolute inset-0 h-full w-full flex items-center justify-center transition-opacity" aria-hidden="true">
                <x-icon.moon class="h-4 w-4 text-blue-9" />
            </span>
        </span>
    </button>

    <span class="ml-3 text-gray-11">Appearance mode</span>
</label>

@once
    @push('scripts')
        <script>
            window.addEventListener('refresh-page', event => {
                window.location.reload(false);
            });
        </script>
    @endpush
@endonce