<x-admin-layout>
    <livewire:posts-write :initial-step="$post->exists ? 'posts-wizard-step-compose': null" />
</x-admin-layout>
