@if ($hasTips())
    <div class="w-full max-w-2xl mx-auto mt-16">
        <div class="rounded-md bg-purple-3 border border-purple-6 p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @icon('lightbulb', 'h-6 w-6 text-purple-9')
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm text-purple-11">
                        {{ $getRandomTip }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif