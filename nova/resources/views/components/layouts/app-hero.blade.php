<div class="layout-app-hero">
    <main>
        @if (session()->has('alert'))
            @include('components.partials.alert')
        @endif

        {!! $template ?? false !!}
    </main>
</div>