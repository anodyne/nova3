@props([
    // the text to display on the tab
    'label' => 'tab',
    // available options are true or false as strings. setting this to true will set this tab
    // as the active tab and will be highlighted
    'active' => false,
    // defines if the tab is disabled. available options are true or false as strings not booleans
    'disabled' => false,
    // unique way to identify this tab using css or javascript
    // this name is used for switching to a corresponding tab content
    // if url => 'default'
    'name' => 'tab',
    // the default action of a tab is to switch to its corresponding tab content div
    // to enable switching, the tab content div needs to have the same name as the tab
    // the alternative action is to pass a url. clicking on the tab will open the url
    'url' => 'default',
])

@aware(['color' => 'blue'])

@php
    $name = preg_replace('/[\s]/', '-', $name);
    $active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp

<button
    type="button"
    data-slot="tab"
    class="flex flex-1 justify-center whitespace-nowrap rounded-lg px-4 py-2 text-base font-medium ring-1 ring-transparent transition focus:outline-none sm:text-sm/6 lg:flex-initial lg:px-3 lg:py-1"
    x-bind:class="{
        'bg-white dark:bg-gray-950 shadow text-gray-900 dark:text-white ring-gray-950/5 dark:ring-white/5':
            isTab('{{ $name }}'),
        'text-gray-500 ring-transparent hover:text-gray-900 dark:hover:text-white':
            ! isTab('{{ $name }}'),
    }"
    x-on:click.prevent="switchTab('{{ $name }}')"
>
    {{ $slot }}
</button>
