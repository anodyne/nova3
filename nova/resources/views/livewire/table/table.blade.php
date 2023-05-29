@php
    $hasHeading = $table->hasHeading();
    $hasDescription = $table->hasDescription();
    $heading = $table->getHeading();
    $description = $table->getDescription();

    $emptyStateHeading = $table->getEmptyStateHeading();
    $emptyStateDescription = $table->getEmptyStateDescription();
    $emptyStateIcon = $table->getEmptyStateIcon();

    $records = $table->data();

    $columns = $table->getColumns();
@endphp

<x-panel>
  @if ($hasHeading || $hasDescription)
    <x-panel.header :title="$heading" :message="$description" :border="$records->count() === 0">
      <x-slot:actions>
        <x-button.filled :href="route('notes.create')" leading="add" color="primary">
          Add
        </x-button.filled>
      </x-slot:actions>
    </x-panel.header>
  @endif

  <div class="relative overflow-x-auto">
    @if ($records->count() === 0)
      <x-empty-state.large
        :title="$emptyStateHeading"
        :message="$emptyStateDescription"
        :icon="$emptyStateIcon"
      ></x-empty-state.large>
    @else
      <table class="w-full text-left">
        <thead>
          <tr class="border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-700/25">
            @foreach($columns as $column)
              <th class="text-sm font-medium text-gray-500 dark:text-gray-400">
                <div class="py-3 px-6 flex items-center">
                  {{ $column->label }}
                </div>
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach($records as $row)
            <tr class="border-t border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/10">
              @foreach($columns as $column)
                <td>
                  <div class="py-3 px-6 flex items-center cursor-pointer">
                    {{ $row[$column->key] }}
                    {{-- <x-dynamic-component
                        :component="$column->component"
                        :value="$row[$column->key]"
                    >
                    </x-dynamic-component> --}}
                  </div>
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>

      <x-content-box height="xs" class="border-t border-gray-200 dark:border-gray-800">
        {{ $records->withQueryString()->links() }}
      </x-content-box>
    @endif
  </div>
</x-panel>