<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Migrate from Nova 2</h1>

        <p class="text-lg/8 text-gray-600">
            Below are all of the available roles in Nova. In order to proceed with the migration process, you will need
            to assign at least 1 user to either the Site Owner or Site Admin role(s).
        </p>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-panel class="overflow-hidden">
            <div class="divide-y divide-gray-200">
                @foreach ($roles as $role)
                    <x-content-box height="sm">
                        <div class="space-y-6" x-data="{ expanded: @js($role->name != 'active') }">
                            <div class="flex items-start justify-between">
                                <div class="flex flex-1 flex-col gap-2">
                                    <div class="flex flex-1 items-center gap-3">
                                        <x-h4>{{ $role->display_name }}</x-h4>
                                        <x-badge>{{ $role->user_count }}</x-badge>
                                    </div>
                                    <div>
                                        <button
                                            class="rounded-full bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 transition hover:bg-gray-100"
                                            x-on:click="expanded = !expanded"
                                        >
                                            <span x-show="expanded">Hide the full list of users &uarr;</span>
                                            <span x-show="!expanded" x-cloak>
                                                Show the full list of users &darr;
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <x-button.setup :href="url('setup/migrate/configure-database')" size="xs">
                                        Go &rarr;
                                    </x-button.setup>
                                </div>
                            </div>
                            @if ($role->user_count > 0)
                                <div x-show="expanded" x-collapse x-cloak>
                                    <div class="flex flex-wrap items-center gap-1">
                                        @foreach ($role->user as $user)
                                            <x-badge>{{ $user->name }}</x-badge>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </x-content-box>
                @endforeach
            </div>
        </x-panel>
    </div>
</div>
