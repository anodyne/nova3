<template>
    <div class="p-6">
        <div class="uppercase tracking-wide text-sm font-semibold text-grey-400 mb-3">My Unread Messages</div>

        <div class="flex items-start">
            <img src="https://api.adorable.io/avatars/114/cab@example.com.png" class="rounded-full h-10 w-10 mr-4">
            <div class="flex flex-col text-sm">
                <div class="font-medium">Story Planning</div>
                <div class="text-grey-400">45 minutes ago</div>
            </div>
        </div>

        <div class="flex items-start mt-6">
            <img src="https://api.adorable.io/avatars/114/xxx@example.com.png" class="rounded-full h-10 w-10 mr-4">
            <div class="flex flex-col text-sm">
                <div class="font-medium">Back from vacation</div>
                <div class="text-grey-400">4 hours ago</div>
            </div>
        </div>

        <div class="flex items-start mt-6">
            <img src="https://api.adorable.io/avatars/114/yyy@example.com.png" class="rounded-full h-10 w-10 mr-4">
            <div class="flex flex-col text-sm">
                <div class="font-medium">Upcoming LOA</div>
                <div class="text-grey-400">6 hours ago</div>
            </div>
        </div>

        <div class="flex items-start mt-6">
            <img src="https://api.adorable.io/avatars/114/zzz@example.com.png" class="rounded-full h-10 w-10 mr-4">
            <div class="flex flex-col text-sm">
                <div class="font-medium">New character idea</div>
                <div class="text-grey-400">7 hours ago</div>
            </div>
        </div>

        <div class="flex items-start mt-6">
            <a href="#" class="flex items-center font-medium text-grey-300 bg-grey-700 rounded px-3 py-2 w-full justify-center">
                Go to my inbox
                <app-icon
                    name="arrow-right"
                    class="ml-1"
                    icon-class="h-5 w-5"
                ></app-icon>
            </a>
        </div>
    </div>
</template>

<script>
export default {};
</script>
