<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <div class="nv-logos-wrapper grid grid-cols-2 items-center gap-x-8 gap-y-16">
            <div class="mx-0 w-full max-w-xl">
                @if (filled($heading))
                    <x-public::preview.h2>Heading</x-public::preview.h2>
                @endif

                @if (filled($description))
                    <x-public::preview.lead
                        @class([
                            'mt-4' => filled($heading),
                        ])
                        markdown
                    >
                        {{ $description }}
                    </x-public::preview.lead>
                @endif
            </div>

            <div class="mx-0 grid w-full max-w-none grid-cols-2 items-center gap-y-14 pl-8">
                @foreach ($logos as $logo)
                    <x-icon name="image" class="h-12 w-12 object-contain object-left text-gray-500"></x-icon>
                @endforeach
            </div>
        </div>
    </div>
</div>
