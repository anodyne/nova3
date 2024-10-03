<x-public-layout>
    <div class="@container advanced-page character-bio">
        <div class="avatar-container">
            <x-avatar :src="$character->avatar_url" size="3xl"></x-avatar>
        </div>

        <div class="bio-content">
            <div class="character-details">
                <div class="name">
                    <x-public::h1>{{ $character->name }}</x-public::h1>

                    <div class="rank">
                        <x-rank :rank="$character->rank"></x-rank>
                    </div>
                </div>

                <div class="metadata">
                    <div class="metadata-item">
                        <div class="metadata-item-leading">Rank</div>
                        <div class="metadata-item-label">
                            {{ $character->rank->name->name }}
                        </div>
                    </div>

                    <div class="metadata-item">
                        <div class="metadata-item-leading">
                            {{ str('Position')->plural($character->positions->count()) }}
                        </div>
                        <div class="metadata-item-label">
                            {{ $character->positions->implode('name', ' & ') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="horizontal-divider"></div>

            <div class="form">
                <livewire:dynamic-form :form="$form" :submission="$character->characterFormSubmission" :static="true" />
            </div>
        </div>
    </div>
</x-public-layout>
