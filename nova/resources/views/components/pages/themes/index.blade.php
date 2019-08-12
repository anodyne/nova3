@pageHeader
    Themes

    @slot('controls')
        <a href="{{ route('themes.create') }}" class="button is-primary">
            Add Theme
        </a>
    @endslot
@endpageHeader

@if ($themes->count() > 0)
    <div class="row">
    @foreach ($themes as $theme)
        <div class="col-6 mb-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $theme->name }}</div>
                    <div class="card-subtitle">themes/{{ $theme->location }}</div>
                </div>

                <div class="card-body"></div>

                <div class="card-footer">
                    <a href="{{ route('themes.edit', $theme) }}" class="button is-secondary">
                        <icon name="edit"></icon>
                    </a>
                    <a href="{{ route('themes.edit', $theme) }}" class="button is-danger">
                        <icon name="delete"></icon>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@else
    No themes here
@endif