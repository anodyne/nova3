@props([
    'list',
    'panels',
])

<el-tab-group data-slot="tabs">
    <el-tab-list
        class="inline-flex h-10 rounded-[10px] bg-gray-800/5 p-[5px] shadow-[inset_0_0_1.5px_.5px_#0000001F] dark:bg-white/10"
    >
        {{ $list }}
    </el-tab-list>

    <el-tab-panels>
        {{ $panels }}
    </el-tab-panels>
</el-tab-group>
