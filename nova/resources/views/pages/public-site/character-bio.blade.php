@extends($meta->template)

@section('content')
    <div class="@container nova-advanced-page-content">
        <div class="nv-character-bio">
            <div class="avatar-container">
                <x-avatar :src="$character->avatar_url" size="3xl"></x-avatar>
            </div>

            <div class="bio-content">
                <div class="character-details">
                    <div class="character-name">
                        <x-public::h1>{{ $character->name }}</x-public::h1>

                        <div class="rank">
                            <x-rank :rank="$character->rank"></x-rank>
                        </div>
                    </div>

                    <div class="character-metadata">
                        <div class="metadata-item">
                            {{ $character->rank->name->name }}
                        </div>

                        <div class="divider">/</div>

                        <div class="metadata-item">
                            {{ $character->positions->implode('name', ' & ') }}
                        </div>
                    </div>
                </div>

                <div class="horizontal-divider"></div>

                <div class="form">
                    <livewire:dynamic-form
                        :form="$form"
                        :submission="$character->characterFormSubmission"
                        :static="true"
                    />
                </div>
            </div>
        </div>
    </div>
@endsection
