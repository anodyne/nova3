@extends($meta->template)

@section('content')
    @include('pages.dashboards.whats-new.' . request()->input('feature', 'overview'))
@endsection