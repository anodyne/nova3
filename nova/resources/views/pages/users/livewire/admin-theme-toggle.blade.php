<div class="@container" x-data="adminThemeToggle(@entangle('appearance'))" x-cloak>
    <div class="@lg:hidden flex flex-col gap-1.5 px-2 py-1.5">
        <label class="text-xs font-medium text-gray-600 dark:text-gray-400">Appearance</label>

        <div class="grid w-full grid-cols-3 rounded-md bg-gray-100 p-1 dark:bg-gray-700">
            <button
                class="flex items-center justify-center space-x-2 rounded px-3 py-1 text-xs font-medium transition"
                x-bind:class="{
                    'bg-white dark:bg-gray-500 text-gray-700 dark:text-gray-100 shadow ring-1 ring-gray-900/5 dark:highlight-white/10':
                        isLightThemeSelected(),
                    'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300':
                        ! isLightThemeSelected(),
                }"
                x-on:click.prevent="setTheme('light')"
            >
                <x-icon name="sun" size="sm"></x-icon>
                <span class="sr-only">Light</span>
            </button>
            <button
                class="flex items-center justify-center space-x-2 rounded px-3 py-1 text-xs font-medium"
                x-bind:class="{
                    'bg-white dark:bg-gray-500 text-gray-700 dark:text-gray-100 shadow ring-1 ring-gray-900/5 dark:highlight-white/10':
                        isDarkThemeSelected(),
                    'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300':
                        ! isDarkThemeSelected(),
                }"
                x-on:click.prevent="setTheme('dark')"
            >
                <x-icon name="moon" size="sm"></x-icon>
                <span class="sr-only">Dark</span>
            </button>
            <button
                class="flex items-center justify-center space-x-2 rounded px-3 py-1 text-xs font-medium"
                x-bind:class="{
                    'bg-white dark:bg-gray-500 text-gray-700 dark:text-gray-100 shadow ring-1 ring-gray-900/5 dark:highlight-white/10':
                        isSystemThemeSelected(),
                    'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300':
                        ! isSystemThemeSelected(),
                }"
                x-on:click.prevent="setTheme()"
            >
                <x-icon name="device-desktop" size="sm"></x-icon>
                <span class="sr-only">System</span>
            </button>
        </div>
    </div>
</div>

@once
    @push('headScripts')
        <script>
            if (
                localStorage.theme === "dark" ||
                (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)
            ) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        </script>
    @endpush

    @push('scripts')
        <script>
            window.addEventListener("refresh-page", (event) => {
                window.location.reload(false);
            });
        </script>
    @endpush
@endonce
