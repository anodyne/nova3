<li class="group relative cursor-default select-none px-4 py-2 hover:bg-primary-500" role="option" tabindex="-1">
    <a href="{{ route('admin.stories.show', $result) }}" class="absolute inset-0"></a>

    <div class="space-y-1">
        <h3 class="font-semibold text-gray-900 group-hover:text-white">{{ $result->title }}</h3>
        <p class="text-xs/5 text-gray-600 group-hover:text-primary-200">
            {{ str($result->description)->stripTags()->words(50) }}
        </p>
    </div>
</li>
