<div class="relative" x-data="dateFormatPicker(@js(settings('general')->dateFormatTokensArray()))" x-cloak>
    <x-input.field>
        <input
            type="text"
            x-ref="dateFormatField"
            name="dateFormatTags"
            class="form-field tagify [--tag-bg:theme(colors.gray.100)] [--tag-border-radius:theme(borderRadius.DEFAULT)] [--tag-hover:theme(colors.primary.100)] [--tag-remove-bg:theme(colors.danger.100)] [--tag-text-color:theme(colors.gray.600)] [--tagify-dd-bg-color:theme(colors.white)] [--tagify-dd-color-primary:theme(colors.primary.500)]"
            {{ $attributes }}
        />
    </x-input.field>
</div>
