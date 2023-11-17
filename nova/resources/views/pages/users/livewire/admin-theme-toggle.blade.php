<div x-data="adminThemeToggle(@entangle('appearance'))">
    <x-switch-toggle x-model="appearance" on-value="dark" off-value="light" size="sm"></x-switch-toggle>
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
@endonce
