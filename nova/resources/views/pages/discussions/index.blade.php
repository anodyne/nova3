@extends($meta->template)

@section('content')
    <livewire:discussions-messages-list
        :selected="$discussion?->id"
        :page-heading="$meta->pageHeading"
        :page-subheading="$meta->pageSubheading"
        :page-intro="$meta->pageIntro"
    />
@endsection
