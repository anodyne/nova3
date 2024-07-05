@extends($meta->template)

@section('content')
    <div class="nova-form-content">
        {!! scribble($form->fields ?? ['content' => null])->toHtml() !!}
    </div>
@endsection
