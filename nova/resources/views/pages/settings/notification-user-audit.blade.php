<x-filament.modal-content icon="preferences" title="User preference audit">
    <div class="flex flex-col">
        <div class="flex items-center py-1.5 font-medium text-gray-600 dark:text-gray-400">
            <div class="flex-1">User</div>
            <div class="flex w-20 items-center justify-center">In-app</div>
            <div class="flex w-20 items-center justify-center">Email</div>
        </div>

        @foreach ($record->userNotificationPreferences as $preference)
            <div class="flex items-center py-1.5 even:bg-gray-50">
                <div class="flex-1 truncate">{{ $preference->user->name }}</div>
                <div
                    @class([
                        'flex w-20 items-center justify-center',
                        'text-success-500' => $preference->database,
                        'text-danger-500' => ! $preference->database,
                    ])
                >
                    <x-icon :name="$preference->database ? 'check' : 'dismiss'"></x-icon>
                </div>
                <div
                    @class([
                        'flex w-20 items-center justify-center',
                        'text-success-500' => $preference->mail,
                        'text-danger-500' => ! $preference->mail,
                    ])
                >
                    <x-icon :name="$preference->mail ? 'check' : 'dismiss'"></x-icon>
                </div>
            </div>
        @endforeach
    </div>
</x-filament.modal-content>
