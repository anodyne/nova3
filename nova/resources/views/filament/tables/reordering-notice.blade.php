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

<div>
    <x-filament-tables::header
        :actions="[]"
        :actions-position="$headerActionsPosition"
        class="mb-2"
        :heading="$heading"
        :description="$description"
    />

    <x-content-box height="none" class="mb-6">
        <x-panel.primary icon="arrows-sort" title="Change sorting order">
            <div class="space-y-4">
                <p>
                    {{ str($pluralModelLabel)->ucfirst() }} will appear in the order below whenever they're shown
                    throughout Nova. To change the sorting of {{ $pluralModelLabel }}, drag them to the desired order.
                    Click Finish to return to the management view.
                </p>

                <div>
                    <x-button.filled wire:click="toggleTableReordering" color="primary">Finish</x-button.filled>
                </div>
            </div>
        </x-panel.primary>
    </x-content-box>
</div>
