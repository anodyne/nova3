<div data-slot="control" x-data="adminThemeToggle(@entangle('appearance'))">
    <x-switch x-model="appearance" on-value="dark" off-value="light" id="appearance"></x-switch>
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
