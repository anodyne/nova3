<div class="fixed z-[999999] inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
    <x-toasts.client />

    <x-toasts.server :notification="session('nova.toast')" />
</div>
