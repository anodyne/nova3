@pageHeader
    @slot('pretitle', 'Presentation')

    Themes

    @slot('controls')
        <a href="{{ route('themes.create') }}" class="button button-primary">
            <app-icon name="add" class="mr-2"></app-icon>
            Create Theme
        </a>
    @endslot
@endpageHeader

@if ($themes->count() > 0)
    <div class="row">
    @foreach ($themes as $theme)
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $theme->name }}</div>
                    <div class="card-subtitle">themes/{{ $theme->location }}</div>
                </div>

                <div class="card-body"></div>

                <div class="card-footer">
                    <a href="{{ route('themes.edit', $theme) }}" class="button">Edit</a>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@else
    No themes here
@endif