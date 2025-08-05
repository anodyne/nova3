@props([
    'defaults' => [],
    'value' => null,
])

<div x-data="keyValueField(@js($value ?? $defaults))" class="space-y-2" data-slot="control">
    <template x-for="(row, index) in items" x-bind:key="index">
        <div class="flex items-center gap-2">
            <div class="flex-1">
                <x-input.text placeholder="Label" x-model="row.key" x-on:input="updateJson()"></x-input.text>
            </div>
            <div class="flex-1">
                <x-input.text placeholder="Value" x-model="row.value" x-on:input="updateJson()"></x-input.text>
            </div>

            <x-button type="button" x-on:click="remove(index)" size="none" color="neutral-danger" text>
                <x-icon :name="Icon::Trash" size="sm"></x-icon>
            </x-button>
        </div>
    </template>

    <div class="pt-2">
        <x-button type="button" x-on:click="add()" plain>
            <x-icon :name="Icon::Plus" size="sm"></x-icon>
            Add row
        </x-button>
    </div>

    <input type="hidden" name="{{ data_get($attributes, 'name') }}" x-bind:value="json" />
</div>
