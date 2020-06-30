@props([
    'countWords' => true,
    'initialValue' => '',
    'name',
])

<div x-data="wordCount()" x-init="init()">
    <input id="content" name="{{ $name }}" value="{{ $initialValue }}" type="hidden">

    <trix-editor
        x-ref="editor"
        @if ($countWords) x-on:trix-change="refreshCount($event)" @endif
        input="content"
        class="trix-content relative w-full min-h-56 bg-transparent py-2 px-3 rounded-md border border-gray-200 bg-gray-50 shadow-sm transition ease-in-out duration-200 focus:border-primary-300 focus:bg-white focus:shadow-outline-primary">
    </trix-editor>

    @if ($countWords)
        <div class="mt-2 ml-2px text-sm text-gray-700">
            Word count: <span x-text="count"></span>
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://unpkg.com/trix@1.2.3/dist/trix.js"></script>
    <script>
        function wordCount()
        {
            return {
                count: 0,

                init () {
                    this.refreshCount();
                },

                refreshCount (event) {
                    if (event) {
                        window.Countable.count(event.target.innerText, counter => {
                            this.count = window.Numeral(counter.words).format('0,0');
                        }, {
                            stripTags: true
                        });
                    }

                }
            };
        }
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
@endpush