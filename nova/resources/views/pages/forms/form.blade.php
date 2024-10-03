<x-admin-layout>
    <div class="nova-form-content">
        {!! scribble($form->fields ?? ['content' => null])->toHtml() !!}
    </div>
</x-admin-layout>
