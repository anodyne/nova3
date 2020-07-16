@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$postType->name">
        <x-slot name="pretitle">
            <a href="{{ route('post-types.index') }}">Post Types</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $postType)
                <a href="{{ route('post-types.edit', $postType) }}" class="button button-primary">Edit Post Type</a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form.section title="Post Type Info">
            <x-input.group label="Name">
                <p class="font-semibold">{{ $postType->name }}</p>
            </x-input.group>

            <x-input.group label="Key">
                <p class="font-semibold">{{ $postType->key }}</p>
            </x-input.group>

            <x-input.group label="Description">
                <p class="font-semibold">{{ $postType->description }}</p>
            </x-input.group>
        </x-form.section>

        <x-form.footer>
            <a href="{{ route('post-types.index') }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
