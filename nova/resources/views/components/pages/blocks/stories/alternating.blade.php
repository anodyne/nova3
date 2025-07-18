<x-public::block.container :$container :$content :$block class="nv-stories nv-stories-alternating">
    <livewire:pages-alternating-stories :block-settings="$block" :type="data_get($block, 'storyType')" />
</x-public::block.container>
