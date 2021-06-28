@props([
    'static' => false,
])

<div x-data="stars" class="flex items-center rounded-full space-x-1 overflow-hidden text-sm font-semibold">
    <template x-for="i in 4">
        <button x-bind="star(i)" type="button" x-on:click="setCount(i)" class="flex-1 py-0.5 bg-gray-300 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">
            <span x-text="i">&nbsp;</span>
        </button>
    </template>
</div>

@push('scripts')
    @once
        <script>
            function stars () {
                count: 1,
                setCount(count) {
                    this.count = count
                },
                star: function (i) {

                }
            }
        </script>
    @endonce
@endpush