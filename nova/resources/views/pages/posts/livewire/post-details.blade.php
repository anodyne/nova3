<div class="space-y-12">
    <div class="space-y-6">
        <div>
            <input
                type="text"
                wire:model.blur="title"
                class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 text-3xl font-extrabold tracking-tight text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 dark:border-white/5 dark:text-gray-100"
                placeholder="Add a title"
            />
        </div>

        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-4 md:space-y-0">
            <div class="flex flex-1 items-center gap-2">
                <x-icon name="location" size="sm" class="text-gray-500"></x-icon>
                <input
                    type="text"
                    wire:model.blur="location"
                    class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                    placeholder="Add a location"
                />
            </div>

            <div class="flex flex-1 items-center gap-2">
                <x-icon name="calendar" size="sm" class="text-gray-500"></x-icon>
                <input
                    type="text"
                    wire:model.blur="day"
                    class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                    placeholder="Add a day"
                />
            </div>

            <div class="flex flex-1 items-center gap-2">
                <x-icon name="clock" size="sm" class="text-gray-500"></x-icon>
                <input
                    type="text"
                    wire:model.blur="time"
                    class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                    placeholder="Add a time"
                />
            </div>
        </div>
    </div>

    <div x-cloak>
        <x-editor wire:model.blur="content"></x-editor>
    </div>
</div>
