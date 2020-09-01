{{-- <x-panel class="p-4 | sm:p-6"> --}}
    <div id="editor" class="prose max-w-none w-full focus:outline-none cursor-text">
        {{ $slot }}
    </div>
{{-- </x-panel> --}}

@push('scripts')
    <script src="{{ asset('nova/resources/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#editor',
            plugins: [
                'autolink',
                'code',
                // 'codesample',
                'link',
                // 'lists',
                'media',
                // 'table',
                'image',
                'quickbars',
                // 'codesample',
                // 'help'
            ],
            toolbar: false,
            menubar: false,
            inline: true,
            // quickbars_insert_toolbar: 'quicktable image media codesample',
            quickbars_insert_toolbar: '',
            quickbars_selection_toolbar: 'bold italic underline | formatselect | blockquote quicklink | code',
            // contextmenu: 'undo redo | inserttable | cell row column deletetable | help',
            placeholder: 'Start writing...',
            skin: 'oxide-dark'
        });
    </script>
@endpush