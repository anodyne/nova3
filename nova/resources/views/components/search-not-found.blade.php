<li class="border-t border-yellow-100">
    <div class="block focus:outline-none focus:bg-gray-50">
        <div class="flex items-center px-4 py-4 bg-yellow-50 | sm:px-6">
            @icon('warning', 'h-6 w-6 flex-shrink-0 mr-3 text-yellow-400')
            <span class="font-medium text-yellow-600">
                {{ $slot }}
            </span>
        </div>
    </div>
</li>
