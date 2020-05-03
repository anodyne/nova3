<x-form.field label="{{ $label }}" field-id="{{ $fieldId }}">
    <input
        wire:model="password"
        type="{{ $showPassword ? 'text' : 'password' }}"
        class="field"
        id="{{ $fieldId }}"
        name="{{ $fieldName }}">

    @if ($allowShowingPassword)
        <x-slot name="addonAfter">
            <button
                type="button"
                class="field-addon"
                wire:click="togglePassword"
            >
                @if ($showPassword)
                    <div class="leading-0">
                        @icon('eye-off')
                    </div>
                @else
                    <div class="leading-0">
                        @icon('eye')
                    </div>
                @endif
            </button>
        </x-slot>
    @endif
</x-form.field>