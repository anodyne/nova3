<x-admin-layout>
    <livewire:discussions-messages-list
        :selected="$discussion?->id"
        :page-heading="$meta->pageHeading"
        :page-subheading="$meta->pageSubheading"
        :page-intro="$meta->pageIntro"
    />
</x-admin-layout>
