<label
    data-slot="label"
    class="block select-none text-base/6 text-gray-800 data-[disabled]:opacity-50 sm:text-sm/6 dark:text-white"
    {{ $attributes }}
>
    {{ $slot }}
    @if ($required)
        <span class="font-sembold text-danger-500">*</span>
    @endif
</label>
