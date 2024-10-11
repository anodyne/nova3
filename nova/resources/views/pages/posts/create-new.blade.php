<x-admin-layout>
    <div class="grid gap-12 lg:grid-cols-3">
        <div class="space-y-12 lg:col-span-2">
            <div class="space-y-6">
                <div>
                    <input
                        type="text"
                        wire:model.blur="form.title"
                        class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 text-3xl font-extrabold tracking-tight text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 dark:border-white/5 dark:text-gray-100"
                        placeholder="Add a title"
                    />
                </div>

                <div class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-4 md:space-y-0">
                    <div class="flex flex-1 items-center gap-2">
                        <x-icon name="location" size="sm" class="text-gray-500"></x-icon>
                        <input
                            type="text"
                            wire:model.blur="form.location"
                            class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                            placeholder="Add a location"
                        />
                    </div>

                    <div class="flex flex-1 items-center gap-2">
                        <x-icon name="calendar" size="sm" class="text-gray-500"></x-icon>
                        <input
                            type="text"
                            wire:model.blur="form.day"
                            class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                            placeholder="Add a day"
                        />
                    </div>

                    <div class="flex flex-1 items-center gap-2">
                        <x-icon name="clock" size="sm" class="text-gray-500"></x-icon>
                        <input
                            type="text"
                            wire:model.blur="form.time"
                            class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                            placeholder="Add a time"
                        />
                    </div>
                </div>
            </div>

            <div x-cloak>
                <x-editor :value="old('editor-content', '')"></x-editor>
            </div>

            <div>
                <x-button>Save</x-button>
            </div>
        </div>

        <div>
            <div class="space-y-12">
                {{--
                    <div class="space-y-2">
                    <div class="flex flex-1 items-center gap-2">
                    <x-icon name="location" size="sm" class="text-gray-500"></x-icon>
                    <input
                    type="text"
                    wire:model.blur="form.location"
                    class="block w-full flex-1 appearance-none border-none bg-transparent p-1 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                    placeholder="Add a location"
                    />
                    </div>
                    
                    <div class="flex flex-1 items-center gap-2">
                    <x-icon name="calendar" size="sm" class="text-gray-500"></x-icon>
                    <input
                    type="text"
                    wire:model.blur="form.day"
                    class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                    placeholder="Add a day"
                    />
                    </div>
                    
                    <div class="flex flex-1 items-center gap-2">
                    <x-icon name="clock" size="sm" class="text-gray-500"></x-icon>
                    <input
                    type="text"
                    wire:model.blur="form.time"
                    class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                    placeholder="Add a time"
                    />
                    </div>
                    </div>
                --}}

                <div class="block">
                    <div
                        class="block border-b border-zinc-800/10 pb-4 pt-4 first:pt-0 last:border-b-0 last:pb-0 dark:border-white/10"
                    >
                        <button
                            type="button"
                            class="group/accordion-heading flex w-full cursor-pointer items-center justify-between text-left text-sm font-medium text-zinc-800 dark:text-white [&>svg]:ml-6"
                            data-flux-accordion-heading=""
                            aria-controls="lofi-disclosure-50a1c57ba7cbb"
                            aria-expanded="false"
                        >
                            <div class="flex items-center gap-x-2">
                                <x-icon name="characters" size="sm"></x-icon>
                                <span>Authors</span>
                            </div>

                            <svg
                                class="hidden shrink-0 !text-zinc-800 text-zinc-300 group-hover/accordion-heading:text-zinc-800 group-data-[open]/accordion-heading:block dark:!text-white dark:text-zinc-400 dark:group-hover/accordion-heading:text-white [:where(&)]:size-5"
                                aria-hidden="true"
                                data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>

                            <svg
                                class="block shrink-0 text-zinc-300 group-hover/accordion-heading:text-zinc-800 group-data-[open]/accordion-heading:hidden dark:text-zinc-400 dark:group-hover/accordion-heading:text-white [:where(&)]:size-5"
                                aria-hidden="true"
                                data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>

                        <div class="pt-4 text-sm text-zinc-500 dark:text-zinc-300">
                            <ul>
                                <li
                                    class="flex items-center justify-between rounded-lg px-3 py-1 text-sm/6 font-medium odd:bg-gray-50 dark:odd:bg-gray-700/50"
                                >
                                    <div>Admiral Jean-Luc Picard</div>
                                </li>
                                <li
                                    class="flex items-center justify-between rounded-lg px-3 py-1 text-sm/6 font-medium odd:bg-gray-50 dark:odd:bg-gray-700/50"
                                >
                                    <div>Martok (played by user1)</div>
                                </li>
                            </ul>

                            <div class="flex items-center px-3 py-1">
                                <x-button color="primary" text>Manage authors</x-button>
                            </div>
                        </div>
                    </div>

                    <div
                        class="block border-b border-zinc-800/10 pb-4 pt-4 first:pt-0 last:border-b-0 last:pb-0 dark:border-white/10"
                    >
                        <button
                            type="button"
                            class="group/accordion-heading flex w-full cursor-pointer items-center justify-between text-left text-sm font-medium text-zinc-800 dark:text-white [&>svg]:ml-6"
                            data-flux-accordion-heading=""
                            aria-controls="lofi-disclosure-50a1c57ba7cbb"
                            aria-expanded="false"
                        >
                            <div class="flex items-center gap-x-2">
                                <x-icon name="mature" size="sm"></x-icon>
                                <span>Content ratings</span>
                            </div>

                            <svg
                                class="hidden shrink-0 !text-zinc-800 text-zinc-300 group-hover/accordion-heading:text-zinc-800 group-data-[open]/accordion-heading:block dark:!text-white dark:text-zinc-400 dark:group-hover/accordion-heading:text-white [:where(&)]:size-5"
                                aria-hidden="true"
                                data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>

                            <svg
                                class="block shrink-0 text-zinc-300 group-hover/accordion-heading:text-zinc-800 group-data-[open]/accordion-heading:hidden dark:text-zinc-400 dark:group-hover/accordion-heading:text-white [:where(&)]:size-5"
                                aria-hidden="true"
                                data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </div>

                    <div
                        class="block border-b border-zinc-800/10 pb-4 pt-4 first:pt-0 last:border-b-0 last:pb-0 dark:border-white/10"
                    >
                        <button
                            type="button"
                            class="group/accordion-heading flex w-full cursor-pointer items-center justify-between text-left text-sm font-medium text-zinc-800 dark:text-white [&>svg]:ml-6"
                            data-flux-accordion-heading=""
                            aria-controls="lofi-disclosure-50a1c57ba7cbb"
                            aria-expanded="false"
                        >
                            <div class="flex items-center gap-x-2">
                                <x-icon name="user-scan" size="sm"></x-icon>
                                <span>Post participants</span>
                            </div>

                            <svg
                                class="hidden shrink-0 !text-zinc-800 text-zinc-300 group-hover/accordion-heading:text-zinc-800 group-data-[open]/accordion-heading:block dark:!text-white dark:text-zinc-400 dark:group-hover/accordion-heading:text-white [:where(&)]:size-5"
                                aria-hidden="true"
                                data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>

                            <svg
                                class="block shrink-0 text-zinc-300 group-hover/accordion-heading:text-zinc-800 group-data-[open]/accordion-heading:hidden dark:text-zinc-400 dark:group-hover/accordion-heading:text-white [:where(&)]:size-5"
                                aria-hidden="true"
                                data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </div>

                    <div
                        class="block border-b border-zinc-800/10 pb-4 pt-4 first:pt-0 last:border-b-0 last:pb-0 dark:border-white/10"
                    >
                        <button
                            type="button"
                            class="group/accordion-heading flex w-full cursor-pointer items-center justify-between text-left text-sm font-medium text-zinc-800 dark:text-white [&>svg]:ml-6"
                            data-flux-accordion-heading=""
                            aria-controls="lofi-disclosure-50a1c57ba7cbb"
                            aria-expanded="false"
                        >
                            <div class="flex items-center gap-x-2">
                                <x-icon name="timeline" size="sm"></x-icon>
                                <span>Post position</span>
                            </div>

                            <svg
                                class="hidden shrink-0 !text-zinc-800 text-zinc-300 group-hover/accordion-heading:text-zinc-800 group-data-[open]/accordion-heading:block dark:!text-white dark:text-zinc-400 dark:group-hover/accordion-heading:text-white [:where(&)]:size-5"
                                aria-hidden="true"
                                data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>

                            <svg
                                class="block shrink-0 text-zinc-300 group-hover/accordion-heading:text-zinc-800 group-data-[open]/accordion-heading:hidden dark:text-zinc-400 dark:group-hover/accordion-heading:text-white [:where(&)]:size-5"
                                aria-hidden="true"
                                data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{--
                    <div x-data="{ expanded: true }">
                    <x-panel well>
                    <x-spacing size="sm">
                    <button
                    type="button"
                    class="flex w-full appearance-none items-center justify-between"
                    x-on:click="expanded = !expanded"
                    >
                    <div class="flex items-center space-x-1">
                    <x-fieldset.legend>Manage authors</x-fieldset.legend>
                    </div>
                    <div class="ml-8 flex shrink-0 items-center space-x-3">
                    <x-badge color="gray">3</x-badge>
                    
                    <div x-show="!expanded">
                    <x-icon name="add" size="md" class="text-gray-400 dark:text-gray-500"></x-icon>
                    </div>
                    <div x-show="expanded">
                    <x-icon
                    name="remove"
                    size="md"
                    class="text-gray-400 dark:text-gray-500"
                    ></x-icon>
                    </div>
                    </div>
                    </button>
                    </x-spacing>
                    
                    <div x-show="expanded" x-collapse x-cloak>
                    <x-spacing size="2xs">
                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                    <x-spacing size="xs">
                    <ul>
                    <li
                    class="flex items-center justify-between rounded-lg px-3 py-1 text-sm/6 font-medium odd:bg-gray-50 dark:odd:bg-gray-700/50"
                    >
                    <div>Captain Liam Shaw</div>
                    </li>
                    <li
                    class="flex items-center justify-between rounded-lg px-3 py-1 text-sm/6 font-medium odd:bg-gray-50 dark:odd:bg-gray-700/50"
                    >
                    <div>Marktok (played by admin)</div>
                    </li>
                    </ul>
                    </x-spacing>
                    </x-panel>
                    </x-spacing>
                    </div>
                    </x-panel>
                    </div>
                    
                    <div x-data="{ expanded: false }">
                    <x-panel well>
                    <x-spacing size="sm">
                    <button
                    type="button"
                    class="flex w-full appearance-none items-center justify-between"
                    x-on:click="expanded = !expanded"
                    >
                    <div class="flex items-center space-x-1">
                    <x-fieldset.legend>Content ratings</x-fieldset.legend>
                    </div>
                    <div class="ml-8 flex shrink-0 items-center space-x-3">
                    <div x-show="!expanded">
                    <x-icon name="add" size="md" class="text-gray-400 dark:text-gray-500"></x-icon>
                    </div>
                    <div x-show="expanded">
                    <x-icon
                    name="remove"
                    size="md"
                    class="text-gray-400 dark:text-gray-500"
                    ></x-icon>
                    </div>
                    </div>
                    </button>
                    </x-spacing>
                    
                    <div x-show="expanded" x-collapse x-cloak>
                    <x-spacing size="2xs">
                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5"></x-panel>
                    </x-spacing>
                    </div>
                    </x-panel>
                    </div>
                    
                    <div x-data="{ expanded: true }">
                    <x-panel well>
                    <x-spacing size="sm">
                    <button
                    type="button"
                    class="flex w-full appearance-none items-center justify-between"
                    x-on:click="expanded = !expanded"
                    >
                    <div class="flex items-center space-x-1">
                    <x-fieldset.legend>Review participants</x-fieldset.legend>
                    </div>
                    <div class="ml-8 flex shrink-0 items-center space-x-3">
                    <div x-show="!expanded">
                    <x-icon name="add" size="md" class="text-gray-400 dark:text-gray-500"></x-icon>
                    </div>
                    <div x-show="expanded">
                    <x-icon
                    name="remove"
                    size="md"
                    class="text-gray-400 dark:text-gray-500"
                    ></x-icon>
                    </div>
                    </div>
                    </button>
                    </x-spacing>
                    
                    <div x-show="expanded" x-collapse x-cloak>
                    <x-spacing size="2xs">
                    <x-panel>
                    <div class="divide-y divide-gray-950/5 rounded-b-lg dark:divide-white/5">
                    <x-spacing
                    height="xs"
                    width="sm"
                    class="flex items-center justify-between gap-6"
                    >
                    <div class="flex flex-col space-x-3 sm:flex-row">
                    <div class="flex flex-col gap-0.5">
                    <div class="flex items-center">
                    <span
                    @class([
                    'mr-3 inline-block h-2 w-2 shrink-0 rounded-full bg-success-500',
                    ])
                    ></span>
                    <span class="font-medium">admin</span>
                    </div>
                    <div class="ml-5">
                    <div class="text-sm">Admiral Jean-Luc Picard</div>
                    </div>
                    </div>
                    </div>
                    
                    <x-dropdown placement="bottom-end">
                    <x-slot name="trigger" color="neutral-danger">
                    <x-icon name="remove" size="md"></x-icon>
                    </x-slot>
                    
                    <x-dropdown.group>
                    <x-dropdown.text>
                    Are you sure you want to remove
                    <strong
                    class="font-semibold text-gray-700 dark:text-gray-950/5"
                    >
                    User
                    </strong>
                    and any characters they’re marked as writing as authors of this
                    post?
                    </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                    <x-dropdown.item-danger type="button" icon="remove">
                    Remove
                    </x-dropdown.item-danger>
                    <x-dropdown.item
                    type="button"
                    icon="prohibited"
                    x-on:click.prevent="$dispatch('dropdown-close')"
                    >
                    Cancel
                    </x-dropdown.item>
                    </x-dropdown.group>
                    </x-dropdown>
                    </x-spacing>
                    
                    <x-spacing
                    height="xs"
                    width="sm"
                    class="flex items-center justify-between gap-6"
                    >
                    <div class="flex flex-col space-x-3 sm:flex-row">
                    <div class="flex flex-col gap-0.5">
                    <div class="flex items-center">
                    <span
                    @class([
                    'mr-3 inline-block h-2 w-2 shrink-0 rounded-full bg-danger-500',
                    ])
                    ></span>
                    <span class="font-medium">user1</span>
                    </div>
                    <div class="ml-5">
                    <div class="text-sm italic">Martok</div>
                    </div>
                    </div>
                    </div>
                    
                    <x-dropdown placement="bottom-end">
                    <x-slot name="trigger" color="neutral-danger">
                    <x-icon name="remove" size="md"></x-icon>
                    </x-slot>
                    
                    <x-dropdown.group>
                    <x-dropdown.text>
                    Are you sure you want to remove
                    <strong
                    class="font-semibold text-gray-700 dark:text-gray-950/5"
                    >
                    User
                    </strong>
                    and any characters they’re marked as writing as authors of this
                    post?
                    </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                    <x-dropdown.item-danger type="button" icon="remove">
                    Remove
                    </x-dropdown.item-danger>
                    <x-dropdown.item
                    type="button"
                    icon="prohibited"
                    x-on:click.prevent="$dispatch('dropdown-close')"
                    >
                    Cancel
                    </x-dropdown.item>
                    </x-dropdown.group>
                    </x-dropdown>
                    </x-spacing>
                    
                    <x-spacing
                    height="xs"
                    width="sm"
                    class="flex items-center rounded-b-lg bg-gray-950/[.025] dark:bg-white/[.025]"
                    >
                    <x-dropdown placement="bottom-start">
                    <x-slot name="trigger" color="neutral-danger">
                    <div class="flex items-center gap-2">
                    <x-icon name="remove" size="md"></x-icon>
                    <span>Remove all non-participating users</span>
                    </div>
                    </x-slot>
                    
                    <x-dropdown.group>
                    <x-dropdown.text>
                    Are you sure you want to remove all users who did not
                    participate in writing this post and their characters?
                    </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                    <x-dropdown.item-danger
                    type="button"
                    icon="remove"
                    wire:click="removeAllNonParticipants"
                    >
                    Remove all
                    </x-dropdown.item-danger>
                    <x-dropdown.item
                    type="button"
                    icon="prohibited"
                    x-on:click.prevent="$dispatch('dropdown-close')"
                    >
                    Cancel
                    </x-dropdown.item>
                    </x-dropdown.group>
                    </x-dropdown>
                    </x-spacing>
                    </div>
                    </x-panel>
                    </x-spacing>
                    </div>
                    </x-panel>
                    </div>
                    
                    <div x-data="{ expanded: false }">
                    <x-panel well>
                    <x-spacing size="sm">
                    <button
                    type="button"
                    class="flex w-full appearance-none items-center justify-between"
                    x-on:click="expanded = !expanded"
                    >
                    <div class="flex items-center space-x-1">
                    <x-fieldset.legend>Post position</x-fieldset.legend>
                    </div>
                    <div class="ml-8 flex shrink-0 items-center space-x-3">
                    <div x-show="!expanded">
                    <x-icon name="add" size="md" class="text-gray-400 dark:text-gray-500"></x-icon>
                    </div>
                    <div x-show="expanded">
                    <x-icon
                    name="remove"
                    size="md"
                    class="text-gray-400 dark:text-gray-500"
                    ></x-icon>
                    </div>
                    </div>
                    </button>
                    </x-spacing>
                    
                    <div x-show="expanded" x-collapse x-cloak>
                    <x-spacing size="2xs">
                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5"></x-panel>
                    </x-spacing>
                    </div>
                    </x-panel>
                    </div>
                --}}

                {{--
                    <div class="space-y-4">
                    <div class="space-y-1">
                    <div class="flex items-center gap-x-2">
                    <x-icon name="characters" size="md"></x-icon>
                    <x-h4>Manage authors</x-h4>
                    </div>
                    
                    <x-text>
                    Let players and readers know what to expect from your post by setting the content ratings.
                    These content ratings follow the game’s default ratings unless you specify otherwise.
                    </x-text>
                    </div>
                    
                    <x-button color="primary" text>Update authors</x-button>
                    </div>
                    
                    <div class="space-y-4">
                    <div class="space-y-1">
                    <div class="flex items-center gap-x-2">
                    <x-icon name="mature" size="md"></x-icon>
                    <x-h4>Content ratings</x-h4>
                    </div>
                    
                    <x-text>
                    Let players and readers know what to expect from your post by setting the content ratings.
                    These content ratings follow the game’s default ratings unless you specify otherwise.
                    </x-text>
                    </div>
                    
                    <x-button color="primary" text>Change content ratings</x-button>
                    </div>
                    
                    <div class="space-y-4">
                    <div class="space-y-1">
                    <div class="flex items-center gap-x-2">
                    <x-icon name="user-scan" size="md"></x-icon>
                    <x-h4>Review participants</x-h4>
                    </div>
                    
                    <x-text>
                    You can review players who participated in writing this post to ensure that the proper
                    authors are credited.
                    </x-text>
                    </div>
                    
                    <x-button color="primary" text>Review post participants</x-button>
                    </div>
                    
                    <div class="space-y-4">
                    <div class="space-y-1">
                    <div class="flex items-center gap-x-2">
                    <x-icon name="timeline" size="md"></x-icon>
                    <x-h4>Post position</x-h4>
                    </div>
                    
                    <x-text>
                    Posts live on a timeline which allows you to set exactly where this post should appear in
                    the story’s timeline.
                    </x-text>
                    </div>
                    
                    <x-button color="primary" text>Change post position</x-button>
                    </div>
                --}}

                <div class="space-y-4">
                    <x-button class="w-full" color="primary">Publish post &rarr;</x-button>

                    <x-button class="w-full" plain>
                        <x-icon name="trash" size="sm"></x-icon>
                        <span>Discard draft</span>
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
