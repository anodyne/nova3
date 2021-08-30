<label for="darkmode" class="flex items-center">
    <button id="darkmode" type="button" class="{{ $appearance === 'dark' ? 'bg-blue-9' : 'bg-gray-6' }} relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-7" role="switch" aria-checked="false" wire:click="toggle()">
        <span class="sr-only">Use setting</span>

        <span class="{{ $appearance === 'dark' ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none relative inline-block h-5 w-5 rounded-full bg-gray-1 shadow transform ring-0 transition ease-in-out duration-200">
            <span class="{{ $appearance === 'light' ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100' }} absolute inset-0 h-full w-full flex items-center justify-center transition-opacity" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-9" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                </svg>
            </span>

            <span class="{{ $appearance === 'dark' ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100' }} absolute inset-0 h-full w-full flex items-center justify-center transition-opacity" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-9" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
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