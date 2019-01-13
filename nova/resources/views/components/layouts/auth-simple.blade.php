<div class="layout-auth-simple">
    <main>
        @if (session()->has('alert'))
            @include('components.partials.alert')
        @endif

        {!! $template ?? false !!}
    </main>
</div>