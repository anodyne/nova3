@extends($meta->template)

@section('content')
    <div class="nova-basic-page-content">
        {!! tiptap_converter()->asHTML($page->blocks ?? ['content' => null]) !!}
    </div>
@endsection
