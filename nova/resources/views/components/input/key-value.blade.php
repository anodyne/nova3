@props([
    'defaults' => [],
    'value' => null,
])

<div x-data="keyValueField(@js($value ?? $defaults))" class="space-y-2" data-slot="control">
    <template x-for="(row, index) in items" x-bind:key="index">
        <div class="flex items-center gap-2">
            <div class="flex-1">
                <x-input placeholder="Label" x-model="row.key" x-on:input="updateJson()" />
            </div>
            <div class="flex-1">
                <x-input placeholder="Value" x-model="row.value" x-on:input="updateJson()" />
            </div>

            <x-button type="button" x-on:click="remove(index)" variant="subtle" inset="right top bottom" square>
                <x-icon :name="Tabler::Trash" size="sm" />
            </x-button>
        </div>
    </template>

    <div class="pt-2">
        <x-button type="button" x-on:click="add()" variant="ghost">
            <x-icon :name="Tabler::Plus" size="sm" />
            Add row
        </x-button>
    </div>

    <input type="hidden" name="{{ data_get($attributes, 'name') }}" x-bind:value="json" />
</div>
