<li class="border-t border-yellow-100">
    <div class="block focus:outline-none focus:bg-gray-50">
        <div class="flex items-center px-4 py-4 bg-yellow-200 | sm:px-6">
            @icon('warning', 'h-6 w-6 flex-shrink-0 mr-3 text-yellow-600')
            <span class="font-medium text-yellow-800">
                {{ $slot }}
            </span>
        </div>
    </div>
</li>
