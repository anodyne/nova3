@extends($meta->template)

@section('content')
    <div class="nova-basic-page-content">
        {!! scribble($page->blocks ?? ['content' => null])->toHtml() !!}
    </div>
@endsection
