@use('Nova\Foundation\Helpers\DateHelper')
@use('Nova\Users\Models\Ban')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', $ban::class)
                    <x-button :href="route('admin.bans.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    @if ($ban->bannable)
                        <x-fieldset.field label="User">
                            <x-text>{{ $ban->bannable->name }}</x-text>
                        </x-fieldset.field>

                        <x-fieldset.field label="Email address">
                            <x-text>{{ $ban->bannable->email }}</x-text>
                        </x-fieldset.field>
                    @endif

                    @if ($ban->ip)
                        <x-fieldset.field label="IP address">
                            <x-text class="tabular-nums">{{ $ban->ip }}</x-text>
                        </x-fieldset.field>
                    @endif

                    @if ($ban->created_by)
                        <x-fieldset.field label="Created by">
                            <x-text>{{ $ban->created_by->name }}</x-text>
                        </x-fieldset.field>
                    @endif

                    <x-fieldset.field label="Expires">
                        @if (filled($ban->expired_at))
                            <x-text>{{ DateHelper::formatDate($ban->expired_at) }}</x-text>
                        @else
                            <x-text>No expiration</x-text>
                        @endif
                    </x-fieldset.field>

                    @if (filled($ban->comment))
                        <x-fieldset.field label="Comments">
                            <x-text>{{ $ban->comment }}</x-text>
                        </x-fieldset.field>
                    @endif
                </x-fieldset.field-group>
            </x-fieldset>
        </x-form>
    </x-spacing>
</x-admin-layout>
