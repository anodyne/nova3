@extends($meta->template)

@section('content')
    <div>
        {!! tiptap_converter()->asHTML($page->blocks ?? ['content' => null]) !!}
    </div>
@endsection
