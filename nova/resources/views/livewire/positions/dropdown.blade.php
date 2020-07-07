<div>
    <div x-data="{ open: true, showSubMenu: false }" x-on:show-submenu.window="showSubMenu = true" x-on:hide-submenu.window="showSubMenu = false" @keydown.window.escape="open = false" @click.away="open = false" class="relative inline-block text-left">
      <div>
        <span class="rounded-md shadow-sm">
          <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150" id="options-menu" aria-haspopup="true" aria-expanded="true" x-bind:aria-expanded="open">
            Options
            <svg class="-mr-1 ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </button>
        </span>
      </div>

      <div x-show="open" x-description="Dropdown panel, show/hide based on dropdown state." x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-left absolute left-0 mt-2 w-56 rounded-md shadow-lg">
        <div class="relative rounded-md bg-white shadow-xs overflow-hidden">

          <div x-show="!showSubMenu" class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <div class="block px-4 py-2 text-xs uppercase tracking-wide font-medium leading-5 text-gray-600">Pick a department</div>
            @foreach ($departments as $department)
                <a wire:click.prevent="setDepartment({{ $department->id }})" href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" role="menuitem">{{ $department->name }}</a>
            @endforeach
          </div>

          <div x-show="showSubMenu" class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <a x-on:click.prevent="showSubMenu = false" href="#" class="block px-4 py-2 text-xs uppercase tracking-wide font-medium leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">&larr; Pick a department</a>
            @isset ($positions)
                @foreach ($positions as $position)
                    <a x-on:click.prevent="showSubMenu = false" href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" role="menuitem">{{ $position->name }}</a>
                @endforeach
            @endisset
          </div>
        </div>
      </div>
    </div>

    {{-- <select wire:model="positionId" class="form-select w-full">
        @if (isset($positions))
            <option value="">Select a position</option>
            @foreach ($positions as $position)
                <option value="{{ $position->id }}">{{ $position->name }}</option>
            @endforeach
        @else
            <option value="">Select a department</option>
            @foreach ($departments as $department)
                <option wire:click="setDepartment({{ $department->id }})">
                    {{ $department->name }}
                </option>
            @endforeach
        @endif
    </select> --}}

    {{-- @if (isset($departmentId) && $positions->count() === 0)
        <div class="text-danger-600 font-medium mt-2">No positions available in the department</div>
    @else
        <select wire:model="positionId" class="form-select w-full mt-2" @if ($departmentId === null) disabled @endif>
            <option value="">Select a position</option>
            @isset($positions)
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                @endforeach
            @endisset
        </select>
    @endif --}}
</div>
