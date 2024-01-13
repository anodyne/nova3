<li data-slot="tab">
    <button
        type="button"
        class="rounded-full px-4 py-0.5 text-sm/6 font-semibold"
        x-bind:class="{
            'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white':
                ! isTab('base'),
            'bg-gradient-to-b from-white dark:from-primary-900 dark:to-primary-950 to-primary-50 text-primary-600 dark:text-primary-100 shadow shadow-primary-600/10 dark:shadow-md ring-1 ring-inset ring-primary-600/20 dark:ring-primary-500/20':
                isTab('base'),
        }"
        x-on:click.prevent="switchTab('base')"
    >
        {{ $slot }}
    </button>
</li>
