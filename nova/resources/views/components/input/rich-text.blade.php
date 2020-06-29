@props([
    'initialValue' => '',
    'name',
])

<input id="content" name="{{ $name }}" value="{{ $initialValue }}" type="hidden">
<trix-editor input="content" class="trix-content relative w-full min-h-56 bg-transparent py-2 px-3 rounded-md border border-gray-200 bg-gray-50 shadow-sm transition ease-in-out duration-200 focus:border-primary-300 focus:bg-white focus:shadow-outline-primary"></trix-editor>

@push('scripts')
    <script src="https://unpkg.com/trix@1.2.3/dist/trix.js"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
@endpush