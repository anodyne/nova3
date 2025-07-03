@php
    $bgColor = data_get($content, 'bg.color') ?? data_get($container, 'bg.color');
@endphp

<x-public::block.container :$container :$content :$block class="nv-stories nv-stories-timeline">
    <div class="mt-12">
        <livewire:public-stories-timeline :sort-direction="data_get($block, 'timelineSorting')" :bg-color="$bgColor" />
    </div>
</x-public::block.container>
