<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <div class="mb-8 font-[family-name:--font-body]">
            <x-panel.primary
                title="Character manifest settings"
                icon="characters"
                description="If you’d like to update the settings for this instance of the manifest, you can do so by editing the block’s settings. These changes will only impact this manifest block."
            ></x-panel.primary>
        </div>

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
