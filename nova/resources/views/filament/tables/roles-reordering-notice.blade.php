@php
    $table = $this->getTable();

    $headerActionsPosition = $table->getHeaderActionsPosition();
    $heading = $table->getHeading();
    $description = $table->getDescription();
    $isReorderable = $table->isReorderable();
    $groups = $table->getGroups();
    $isGlobalSearchVisible = $table->isSearchable();
    $hasFilters = $table->isFilterable();
    $isColumnToggleFormVisible = $table->hasToggleableColumns();
    $bulkActions = array_filter(
        $table->getBulkActions(),
        fn (\Filament\Tables\Actions\BulkAction|\Filament\Tables\Actions\ActionGroup $action): bool => $action->isVisible(),
    );
    $pluralModelLabel = $table->getPluralModelLabel();
@endphp

<x-content-box height="none" width="none">
    <x-panel.primary icon="arrows-sort" title="Change sorting order">
        <div class="space-y-4">
            <p>
                Sorting roles allows for admins to control the hierarchy of roles in the system to ensure that users
                with a lower role cannot give themselves higher privileges.
            </p>

            <p>
                Top roles have the greatest privileges &ndash; place the most important roles with the highest potential
                impact higher on the list, to ensure users can't gain unwanted access to areas of Nova.
            </p>

            <div>
                <x-button wire:click="toggleTableReordering" color="primary">Finish</x-button>
            </div>
        </div>
    </x-panel.primary>
</x-content-box>
