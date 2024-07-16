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
    @class([
        'flex shrink-0 items-center gap-x-2 rounded-full px-3.5 py-1',
        '[&>[data-slot=icon]]:-mx-0.5 [&>[data-slot=icon]]:shrink-0 [&>[data-slot=icon]]:text-[--tab-icon]',
    ])
    x-bind:class="{
        'bg-white font-semibold text-gray-950 [--tab-icon:theme(colors.gray.500)] shadow-sm dark:bg-white/15 dark:text-white dark:[--tab-icon:theme(colors.gray.400)] dark:shadow-none ring-1 ring-gray-950/5':
            isTab('{{ $name }}'),
        'font-medium text-gray-600 [--tab-icon:theme(colors.gray.500)] hover:bg-gray-900/10 hover:text-gray-950 dark:text-gray-400 dark:hover:bg-white/[.08] dark:hover:text-white dark:[--tab-icon:theme(colors.gray.400)]':
            ! isTab('{{ $name }}'),
    }"
    x-on:click.prevent="switchTab('{{ $name }}')"
>
    {{ $slot }}
</button>
