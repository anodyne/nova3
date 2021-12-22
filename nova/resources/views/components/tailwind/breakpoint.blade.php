@if (config('app.debug'))
    <div class="absolute bottom-8 left-4">
        <div class="rounded font-mono text-[0.625rem] leading-6 px-1.5 ring-1 ring-inset dark:ring-0 bg-gray-6 ring-gray-6 dark:bg-gray-7 dark:highlight-white/5">
            <span class="sm:hidden">xs</span>
            <span class="hidden sm:block md:hidden">sm</span>
            <span class="hidden md:block lg:hidden">md</span>
            <span class="hidden lg:block xl:hidden">lg</span>
            <span class="hidden xl:block">xl</span>
        </div>
    </div>
@endif