<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <x-timeline>
            <div>
                <x-timeline.item
                    :last="false"
                    :highlighted="false"
                    class="bg-gray-400 ring-white dark:bg-gray-500 dark:ring-gray-900"
                >
                    <x-slot name="title">
                        <div class="flex w-full items-center justify-between">
                            <div class="flex items-center gap-x-6">
                                <x-public::preview.h2>Story title</x-public::preview.h2>

                                <x-badge color="gray">Status</x-badge>
                            </div>
                        </div>
                    </x-slot>

                    <div class="w-full">
                        <div
                            class="prose max-w-4xl dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400"
                        >
                            Excepteur Lorem irure sunt cupidatat commodo commodo qui anim id. Ullamco officia elit
                            reprehenderit in dolore deserunt ea minim ex veniam Lorem do. Nisi fugiat Lorem eu voluptate
                            consequat. Voluptate ex reprehenderit magna aute consequat anim. Laborum veniam veniam amet
                            laborum eu duis amet amet Lorem nulla.
                        </div>

                        <div class="mt-8">
                            <x-public::preview.button href="#">Go to story &rarr;</x-public::preview.button>
                        </div>
                    </div>
                </x-timeline.item>
            </div>
            <div>
                <x-timeline.item :last="false" :highlighted="true" class="bg-primary-500 ring-primary-500">
                    <x-slot name="title">
                        <div class="flex w-full items-center justify-between">
                            <div class="flex items-center gap-x-6">
                                <x-public::preview.h2>Story title</x-public::preview.h2>

                                <x-badge color="primary">Status</x-badge>
                            </div>
                        </div>
                    </x-slot>

                    <div class="w-full">
                        <div
                            class="prose max-w-4xl dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400"
                        >
                            Excepteur Lorem irure sunt cupidatat commodo commodo qui anim id. Ullamco officia elit
                            reprehenderit in dolore deserunt ea minim ex veniam Lorem do. Nisi fugiat Lorem eu voluptate
                            consequat. Voluptate ex reprehenderit magna aute consequat anim. Laborum veniam veniam amet
                            laborum eu duis amet amet Lorem nulla.
                        </div>

                        <div class="mt-8">
                            <x-public::preview.button href="#">Go to story &rarr;</x-public::preview.button>
                        </div>
                    </div>
                </x-timeline.item>
            </div>
            <div>
                <x-timeline.item :last="true" :highlighted="false" class="bg-info-500 ring-white dark:ring-gray-900">
                    <x-slot name="title">
                        <div class="flex w-full items-center justify-between">
                            <div class="flex items-center gap-x-6">
                                <x-public::preview.h2>Story title</x-public::preview.h2>

                                <x-badge color="info">Status</x-badge>
                            </div>
                        </div>
                    </x-slot>

                    <div class="w-full">
                        <div
                            class="prose max-w-4xl dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400"
                        >
                            Excepteur Lorem irure sunt cupidatat commodo commodo qui anim id. Ullamco officia elit
                            reprehenderit in dolore deserunt ea minim ex veniam Lorem do. Nisi fugiat Lorem eu voluptate
                            consequat. Voluptate ex reprehenderit magna aute consequat anim. Laborum veniam veniam amet
                            laborum eu duis amet amet Lorem nulla.
                        </div>

                        <div class="mt-8">
                            <x-public::preview.button href="#">Go to story &rarr;</x-public::preview.button>
                        </div>
                    </div>
                </x-timeline.item>
            </div>
        </x-timeline>
    </div>
</div>
