<ui-sidebar-toggle
    class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2"
    data-flux-sidebar-collapse
>
    <flux:tooltip content="Toggle sidebar" position="right">
        <button
            type="button"
            class="relative inline-flex size-10 items-center justify-center gap-2 rounded-lg bg-transparent text-sm font-medium whitespace-nowrap text-zinc-500 hover:bg-zinc-800/5 hover:text-zinc-800 disabled:pointer-events-none disabled:cursor-default disabled:opacity-75 in-data-flux-sidebar-collapsed-desktop:cursor-e-resize rtl:in-data-flux-sidebar-collapsed-desktop:cursor-w-resize dark:text-zinc-400 dark:hover:bg-white/15 dark:hover:text-white dark:disabled:opacity-75 [&[collapsible='mobile']]:in-data-flux-sidebar-on-desktop:hidden"
        >
            <x-icon :name="Tabler::LayoutSidebar" size="md" />
        </button>
    </flux:tooltip>
</ui-sidebar-toggle>
