@pageHeader
    Roles

    @slot('controls')
        <a href="{{ route('roles.create') }}" class="button is-primary">
            Add Role
        </a>
    @endslot
@endpageHeader

@if ($roles->count() > 0)
    <div class="row">
    @foreach ($roles as $role)
        <div class="col-6 mb-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $role->title }}</div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('roles.edit', $role) }}" class="button is-secondary">
                        <icon name="edit"></icon>
                    </a>
                    <a href="{{ route('roles.edit', $role) }}" class="button is-danger">
                        <icon name="delete"></icon>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@else
    No roles here
@endif