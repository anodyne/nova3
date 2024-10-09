<li class="group relative cursor-default select-none px-4 py-2 hover:bg-primary-500" role="option" tabindex="-1">
    <a href="{{ route('admin.characters.show', $result) }}" class="absolute inset-0"></a>

    <div class="space-y-1">
        <h3 class="font-semibold text-gray-900 group-hover:text-white">{{ $result->display_name }}</h3>
        <p class="text-xs/5 text-gray-600 group-hover:text-primary-200">
            {{ $result->positions->implode('name', ' & ') }}
        </p>
    </div>
</li>
