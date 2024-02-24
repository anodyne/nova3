@if (config('app.debug'))
    <div class="font-mono text-[0.625rem] leading-6">
        <div class="@container/breakpoint">
            <span class="@sm/breakpoint:hidden">@xs</span>
            <span class="@sm/breakpoint:block @md/breakpoint:hidden @xs/breakpoint:hidden">@sm</span>
            <span class="@md/breakpoint:block @lg/breakpoint:hidden @xs/breakpoint:hidden">@md</span>
            <span class="@lg/breakpoint:block @xl/breakpoint:hidden @xs/breakpoint:hidden">@lg</span>
            <span class="@xl/breakpoint:block @xs/breakpoint:hidden @2xl/breakpoint:hidden">@xl</span>
            <span class="@xs/breakpoint:hidden @2xl/breakpoint:block @3xl/breakpoint:hidden">@2xl</span>
            <span class="@xs/breakpoint:hidden @3xl/breakpoint:block @4xl/breakpoint:hidden">@3xl</span>
            <span class="@xs/breakpoint:hidden @4xl/breakpoint:block @5xl/breakpoint:hidden">@4xl</span>
            <span class="@xs/breakpoint:hidden @5xl/breakpoint:block @6xl/breakpoint:hidden">@5xl</span>
            <span class="@xs/breakpoint:hidden @6xl/breakpoint:block @7xl/breakpoint:hidden">@6xl</span>
            <span class="@xs/breakpoint:hidden @7xl/breakpoint:block">@7xl</span>
        </div>
    </div>
@endif
