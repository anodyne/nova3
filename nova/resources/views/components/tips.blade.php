@if ($hasTips())
    <div class="w-full max-w-2xl mx-auto mt-16">
        <div class="sm:rounded-lg bg-purple-3 border-t border-b sm:border-l sm:border-r border-purple-6 p-4">
            <div class="flex items-start">
                <div class="shrink-0">
                    @icon('lightbulb', 'h-7 w-7 md:h-6 md:w-6 text-purple-9')
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-base md:text-sm text-purple-11">
                        {{ $getRandomTip }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif