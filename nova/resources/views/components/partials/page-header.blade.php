<div class="page-header">
    <div class="page-header-content">
        @if (isset($pretitle))
            <div class="page-header-pretitle">
                {{ $pretitle }}
            </div>
        @endif

        <div class="page-header-title">
            {{ $slot }}
        </div>
    </div>

    @if (isset($controls))
        <div class="page-header-controls">
            {!! $controls !!}
        </div>
    @endif
</div>