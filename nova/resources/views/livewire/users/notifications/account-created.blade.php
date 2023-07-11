<div class="flex items-start">
    <div class="mr-4 shrink-0 rounded-md bg-info-100 p-1.5 leading-0">
        <x-icon name="users" size="xl" class="text-info-600"></x-icon>
    </div>
    <div class="flex flex-col">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Account Created</h2>

            @if ($notification['unread'])
                <button
                    wire:click="markNotificationAsRead('{{ $notification['id'] }}')"
                    type="button"
                    class="group ml-6 shrink-0 rounded-full border-4 border-transparent transition duration-200 ease-in-out hover:border-primary-100"
                >
                    <div class="group-hover:bg-primary-5 h-2.5 w-2.5 rounded-full bg-primary-50"></div>
                </button>
            @endif
        </div>
        <p class="mt-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        <p class="mt-2 text-sm text-gray-500">{{ data_get($notification, 'date') }}</p>
    </div>
</div>
