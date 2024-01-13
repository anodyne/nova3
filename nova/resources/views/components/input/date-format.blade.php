@aware(['error', 'name', 'id'])

<div
    data-slot="control"
    class="relative"
    x-data="dateFormatPicker(@js(settings('general')->dateFormatTokensArray()))"
    x-cloak
>
    <x-input.text
        x-ref="dateFormatField"
        class="tagify border-solid [--tag-bg:theme(colors.gray.100)] [--tag-border-radius:theme(borderRadius.DEFAULT)] [--tag-hover:theme(colors.primary.100)] [--tag-remove-bg:theme(colors.danger.100)] [--tag-text-color:theme(colors.gray.600)] [--tagify-dd-bg-color:theme(colors.white)] [--tagify-dd-color-primary:theme(colors.primary.500)]"
        {{ $attributes }}
    ></x-input.text>
</div>
