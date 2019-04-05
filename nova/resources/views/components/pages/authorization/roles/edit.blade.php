@pageHeader
    @slot('pretitle', 'Roles')
    {{ $role->title }}
@endpageHeader

<section>
    <form action="{{ route('roles.update', $role) }}" method="post" role="form">
        @csrf
        @method('patch')

        <div class="form-section">
            <div class="form-section-column-content">
                <div class="form-section-header">Role Info</div>
                <p class="form-section-message">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, ratione minus animi esse sit dicta, eos, atque omnis placeat enim tempora. Unde accusantium ad illo earum a sit saepe explicabo.</p>
            </div>

            <div class="form-section-column-form">
                <form-field
                    label="Display Name"
                    field-id="title"
                    name="title"
                >
                    <div class="field-group">
                        <input type="text" name="title" id="title" class="field" value="{{ old('title') ?? $role->title }}">
                    </div>
                </form-field>

                <form-field
                    label="Name"
                    field-id="name"
                    name="name"
                >
                    <div class="field-group">
                        <input type="text" name="name" id="name" class="field" value="{{ old('name') ?? $role->name }}">
                    </div>
                </form-field>
            </div>
        </div>

        <div class="form-controls">
            <button type="submit" class="button is-primary is-large">Update</button>

            <a href="{{ route('roles.index') }}" class="button is-secondary is-large">Cancel</a>
        </div>
    </form>
</section>