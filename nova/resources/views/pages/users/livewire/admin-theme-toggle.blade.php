<div data-slot="control" x-data="adminThemeToggle($wire.entangle('appearance').live)">
    <x-switch x-model="appearance" on-value="dark" off-value="light" id="appearance"></x-switch>
</div>
