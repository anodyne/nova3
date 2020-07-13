<div class="flex items-start">
    <div class="flex-shrink-0 rounded-md leading-0 p-1.5 mr-4 bg-purple-50">
        @icon('users', 'h-8 w-8 text-purple-600')
    </div>
    <div class="flex flex-col">
        <div class="flex items-center justify-between">
            <h2 class="text-xs uppercase tracking-wider font-semibold text-gray-500">Account Created</h2>

            @if ($notification['unread'])
                <button wire:click="markNotificationAsRead('{{ $notification['id'] }}')" type="button" class="group rounded-full flex-shrink-0 ml-6 border-4 border-transparent transition ease-in-out duration-150 hover:border-blue-100">
                    <div class="rounded-full h-2.5 w-2.5 bg-blue-400 group-hover:bg-blue-500"></div>
                </button>
            @endif
        </div>
        <p class="mt-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        <p class="mt-2 text-sm text-gray-500">{{ data_get($notification, 'date') }}</p>
    </div>
</div>
