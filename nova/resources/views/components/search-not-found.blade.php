<li class="border-t border-yellow-6">
    <div class="block focus:outline-none focus:bg-gray-50">
        <div class="flex items-center px-4 py-4 bg-yellow-3 | sm:px-6">
            @icon('warning', 'h-6 w-6 flex-shrink-0 mr-3 text-yellow-9')
            <span class="font-medium text-yellow-11">
                {{ $slot }}
            </span>
        </div>
    </div>
</li>
