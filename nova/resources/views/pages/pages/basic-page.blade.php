@extends('public')

@section('content')
    <div>
        {!! tiptap_converter()->asHTML($page->blocks) !!}
    </div>
@endsection
