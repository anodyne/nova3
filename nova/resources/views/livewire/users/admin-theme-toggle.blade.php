<div class="leading-0" x-data="adminThemeToggle(@entangle('appearance'))" x-cloak>
    <x-dropdown placement="bottom-end">
        <x-slot:trigger>
            <span x-show="isLightTheme" :class="{ 'text-blue-9': isLightThemeSelected() }">
                @icon('sun', 'h-6 w-6')
            </span>
            <span x-show="isDarkTheme" :class="{ 'text-blue-9': isDarkThemeSelected() }">
                @icon('moon', 'h-6 w-6')
            </span>
        </x-slot:trigger>

        <x-dropdown.group>
            <x-dropdown.item href="#" @click.prevent="setTheme('light')">
                <div class="flex items-center space-x-2">
                    <span :class="{ 'text-blue-8': isLightThemeSelected() }">
                        @icon('sun', 'h-6 w-6')
                    </span>
                    <span :class="{ 'text-blue-9 font-semibold': isLightThemeSelected() }">Light</span>
                </div>
            </x-dropdown.item>
            <x-dropdown.item href="#" @click.prevent="setTheme('dark')">
                <div class="flex items-center space-x-2">
                    <span :class="{ 'text-blue-8': isDarkThemeSelected() }">
                        @icon('moon', 'h-6 w-6')
                    </span>
                    <span :class="{ 'text-blue-9 font-semibold': isDarkThemeSelected() }">Dark</span>
                </div>
            </x-dropdown.item>
            <x-dropdown.item href="#" @click.prevent="setTheme()">
                <div class="flex items-center space-x-2">
                    <span :class="{ 'text-blue-8': isSystemThemeSelected() }">
                        @icon('desktop', 'h-6 w-6')
                    </span>
                    <span :class="{ 'text-blue-9 font-semibold': isSystemThemeSelected() }">System</span>
                </div>
            </x-dropdown.item>
        </x-dropdown.group>
    </x-dropdown>
</div>

@once
    @push('headScripts')
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    @endpush

    @push('scripts')
        <script>
            window.addEventListener('refresh-page', event => {
                window.location.reload(false);
            });
        </script>
    @endpush
@endonce