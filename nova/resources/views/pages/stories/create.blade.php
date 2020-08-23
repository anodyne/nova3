@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Story">
        <x-slot name="pretitle">
            <a href="{{ route('stories.index') }}">Stories</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('stories.store')">
            <x-form.section title="Story Info">
                <x-input.group label="Title" for="title" :error="$errors->first('title')">
                    <x-input.text id="title" name="title" data-cy="title" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="10">{{ old('description') }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Story Status & Dates">
                <x-input.group label="Status">
                    <select name="status" id="status" class="form-select">
                        <option value="upcoming">Upcoming</option>
                        <option value="current">Current</option>
                        <option value="completed">Completed</option>
                    </select>
                </x-input.group>

                <x-input.group label="Start Date" for="start_date">
                    <x-input.field>
                        <x-slot name="leadingAddOn">@icon('calendar')</x-slot>

                        <x-ui-pikaday name="start_date" id="start_date" format="YYYY-MM-DD" :value="old('start_date', '')" class="field" />
                    </x-input.field>
                </x-input.group>

                <x-input.group label="End Date" for="end_date">
                    <x-input.field>
                        <x-slot name="leadingAddOn">@icon('calendar')</x-slot>

                        <x-ui-pikaday name="end_date" id="end_date" format="YYYY-MM-DD" :value="old('end_date', '')" class="field" />
                    </x-input.field>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Story Hierarchy" message="Stories can be organized inside any story on the timeline and then ordered within the parent story in whatever order you'd like.">
                @livewire('stories:hierarchy', [
                    'parentId' => old('parent_id', 1),
                    'direction' => old('direction', 'before'),
                    'neighbor' => old('neighbor')
                ])
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Story</button>

                <a href="{{ route('stories.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
