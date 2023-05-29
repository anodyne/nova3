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
    fn (\Filament\Tables\Actions\BulkAction | \Filament\Tables\Actions\ActionGroup $action): bool => $action->isVisible(),
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
        <p>Sorting roles allows for admins to control the hierarchy of roles in the system to ensure that users with a lower role cannot give themselves higher privileges.</p>

        <p>Top roles have the greatest privileges &ndash; place the most important roles with the highest potential impact higher on the list, to ensure users can't gain unwanted access to areas of Nova.</p>

        <div>
          <x-button.filled wire:click="toggleTableReordering">Finish</x-button.filled>
        </div>
      </div>
    </x-panel.primary>
  </x-content-box>

  <x-filament::hr
    :x-show="\Illuminate\Support\Js::from($isReorderable || count($groups) || $isGlobalSearchVisible || $hasFilters || $isColumnToggleFormVisible) . ' || (selectedRecords.length && ' . \Illuminate\Support\Js::from(count($bulkActions)) . ')'"
  />
</div>