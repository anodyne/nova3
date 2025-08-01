@props([
    'label' => null,
    'description' => null,
    'error' => null,
    'required' => null,
    'defaults' => [],
    'value' => null,
])

@aware(['form' => null])

@php
    if (filled($form)) {
        $id = data_get($attributes, 'id');

        $errorKey = "{$form->key}.{$id}";
        $error = $errors->getBag('default')->first($errorKey);
    }
@endphp

<x-public::field :$label :$description :id="data_get($attributes, 'id')" :$error :$required>
    <div
        x-data="keyValueField(@js($value ?? $defaults))"
        class="nv-form-field-key-value space-y-2"
        data-slot="control"
    >
        <template x-for="(row, index) in items" x-bind:key="index">
            <div class="flex items-center gap-2">
                <div class="nv-form-field-kv-label flex-1">
                    <x-public::field.text placeholder="Label" x-model="row.key" x-on:input="updateJson()" />
                </div>
                <div class="nv-form-field-kv-value flex-1">
                    <x-public::field.text
                        class="w-1/2"
                        placeholder="Value"
                        x-model="row.value"
                        x-on:input="updateJson()"
                    />
                </div>

                <x-public::button type="button" x-on:click="remove(index)" class="nv-form-field-kv-delete">
                    <x-icon name="trash" size="sm"></x-icon>
                </x-public::button>
            </div>
        </template>

        <x-public::button type="button" x-on:click="add()" class="nv-form-field-kv-add">
            Add row &plus;
        </x-public::button>

        <input type="hidden" name="{{ data_get($attributes, 'name') }}" x-bind:value="json" />
    </div>
</x-public::field>
