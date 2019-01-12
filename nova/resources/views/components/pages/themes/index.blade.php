@pageHeader
    @slot('pretitle', 'Presentation')

    Themes

    @slot('controls')
        <a href="{{ route('themes.create') }}" class="button button-primary">
            Create Theme
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
                    <a href="{{ route('themes.edit', $theme) }}" class="button">
                        <app-icon name="edit"></app-icon>
                    </a>
                    <a href="{{ route('themes.edit', $theme) }}" class="button button-danger">
                        <app-icon name="delete"></app-icon>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@else
    No themes here
@endif