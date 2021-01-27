<div x-data="{ rating: 0 }" class="flex items-center rounded-full space-x-1 overflow-hidden text-sm font-semibold">
    <template v-for="item in 4" x-bind:key="item">
        <a href="#" class="flex-1 py-0.5 bg-gray-300 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">
            <span v-show="rating > 0" v-text="item">&nbsp;</span>
            <span v-show="rating === 0">&nbsp;</span>
        </a>
    </template>
</div>