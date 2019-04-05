@pageHeader
    @slot('pretitle', 'Roles')
    Add Role
@endpageHeader

<section>
    <form action="{{ route('roles.store') }}" method="post" role="form">
        @csrf

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
                        <input type="text" name="title" id="title" class="field" value="{{ old('title') }}">
                    </div>
                </form-field>

                <form-field
                    label="Name"
                    field-id="name"
                    name="name"
                >
                    <div class="field-group">
                        <input type="text" name="name" id="name" class="field" value="{{ old('name') }}">
                    </div>
                </form-field>
            </div>
        </div>

        <div class="form-controls">
            <button type="submit" class="button is-primary is-large">Create</button>

            <a href="{{ route('roles.index') }}" class="button is-secondary is-large">Cancel</a>
        </div>
    </form>
</section>