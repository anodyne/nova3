<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <x-public::preview.block.header
            :orientation="$headerOrientation"
            :heading="$heading"
            :description="$description"
        ></x-public::preview.block.header>

        @if ($layout === 'table')
            <div class="mt-4">
                @if ($showDepartments)
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Department name</h2>
                @endif

                <x-public::preview.manifest.table-row :columns="$columns"></x-public::preview.manifest.table-row>

                <x-public::preview.manifest.table-row :columns="$columns"></x-public::preview.manifest.table-row>

                <x-public::preview.manifest.table-row :columns="$columns"></x-public::preview.manifest.table-row>
            </div>
        @endif

        @if ($layout === 'grid')
            <div class="mt-4 grid grid-cols-3 gap-8">
                <x-public::preview.manifest.grid-item
                    :options="$characterOptions ?? []"
                ></x-public::preview.manifest.grid-item>

                <x-public::preview.manifest.grid-item
                    :options="$characterOptions ?? []"
                ></x-public::preview.manifest.grid-item>

                <x-public::preview.manifest.grid-item
                    :options="$characterOptions ?? []"
                ></x-public::preview.manifest.grid-item>
            </div>
        @endif

        @if ($layout === 'cards')
            <div class="mt-4 grid grid-cols-3 gap-8">
                <x-public::preview.manifest.card
                    :orientation="$cardOrientation"
                    :options="$characterOptions ?? []"
                ></x-public::preview.manifest.card>

                <x-public::preview.manifest.card
                    :orientation="$cardOrientation"
                    :options="$characterOptions ?? []"
                ></x-public::preview.manifest.card>

                <x-public::preview.manifest.card
                    :orientation="$cardOrientation"
                    :options="$characterOptions ?? []"
                ></x-public::preview.manifest.card>
            </div>
        @endif
    </div>
</div>
