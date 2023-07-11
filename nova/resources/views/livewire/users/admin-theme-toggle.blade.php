<div class="leading-0" x-data="adminThemeToggle(@entangle('appearance'))" x-cloak>
    <x-dropdown>
        <x-slot name="trigger">
            <span x-show="isLightTheme" :class="{ 'text-primary-500': isLightThemeSelected() }">
                <x-icon name="sun" size="md"></x-icon>
            </span>
            <span x-show="isDarkTheme" :class="{ 'text-primary-500': isDarkThemeSelected() }">
                <x-icon name="moon" size="md"></x-icon>
            </span>
        </x-slot>

        <x-dropdown.group>
            <x-dropdown.item href="#" x-on:click.prevent="setTheme('light')">
                <div class="flex items-center space-x-2">
                    <span
                        :class="{ 'text-primary-500': isLightThemeSelected(), 'text-gray-500 dark:text-gray-400': !isLightThemeSelected() }"
                    >
                        <x-icon name="sun" size="md"></x-icon>
                    </span>
                    <span :class="{ 'text-primary-500 font-semibold': isLightThemeSelected() }">Light</span>
                </div>
            </x-dropdown.item>
            <x-dropdown.item href="#" x-on:click.prevent="setTheme('dark')">
                <div class="flex items-center space-x-2">
                    <span
                        :class="{ 'text-primary-500': isDarkThemeSelected(), 'text-gray-500 dark:text-gray-400': !isDarkThemeSelected() }"
                    >
                        <x-icon name="moon" size="md"></x-icon>
                    </span>
                    <span :class="{ 'text-primary-500 font-semibold': isDarkThemeSelected() }">Dark</span>
                </div>
            </x-dropdown.item>
            <x-dropdown.item href="#" x-on:click.prevent="setTheme()">
                <div class="flex items-center space-x-2">
                    <span
                        :class="{ 'text-primary-500': isSystemThemeSelected(), 'text-gray-500 dark:text-gray-400': !isSystemThemeSelected() }"
                    >
                        <x-icon name="device-desktop" size="md"></x-icon>
                    </span>
                    <span :class="{ 'text-primary-500 font-semibold': isSystemThemeSelected() }">System</span>
                </div>
            </x-dropdown.item>
        </x-dropdown.group>
    </x-dropdown>
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
