<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <x-public::preview.block.header
            :heading="$heading ?? null"
            :description="$description ?? null"
            :orientation="$headerOrientation"
        ></x-public::preview.block.header>

        <div class="mx-auto mt-12 w-full max-w-xs">
            <div class="space-y-4">
                <div class="flex flex-col gap-y-2">
                    <label class="text-primary-500">Short text</label>
                    <div class="h-8 w-full rounded-lg ring-2 ring-primary-500"></div>
                </div>
                <div class="flex flex-col gap-y-2">
                    <label class="text-gray-600 dark:text-gray-400">Text</label>
                    <div class="h-8 w-full rounded-lg ring-2 ring-gray-400 dark:ring-gray-600"></div>
                </div>
                <div class="flex flex-col gap-y-2">
                    <label class="text-gray-600 dark:text-gray-400">Textarea</label>
                    <div class="h-24 w-full rounded-lg ring-2 ring-gray-400 dark:ring-gray-600"></div>
                </div>
            </div>
            <div class="mt-8 flex gap-x-2">
                <div class="flex items-center rounded-lg bg-primary-500 px-4 pb-2.5 pt-2 leading-none text-white">
                    Button
                </div>
            </div>
        </div>
    </div>
</div>
