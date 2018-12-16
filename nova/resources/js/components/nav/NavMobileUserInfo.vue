<template>
    <div>
        <div class="border-b-2 border-grey-800 p-6">
            <div class="flex items-center">
                <img src="https://api.adorable.io/avatars/114/admin@example.com.png" class="rounded-full h-16 w-16 mr-3">
                <div class="flex flex-col">
                    <div class="text-lg font-semibold text-grey-100">John Doe</div>
                    <div class="flex items-center text-sm text-grey-400 font-medium">
                        <app-icon
                            name="settings"
                            class="mr-2"
                            icon-class="h-5 w-5 text-grey-500"
                        ></app-icon> Edit my account
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="uppercase tracking-wide text-sm font-semibold text-grey-400 mb-3">My Characters</div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://api.adorable.io/avatars/114/ddd@example.com.png" class="rounded-full h-12 w-12 mr-3">
                    <div class="flex flex-col">
                        <div class="text-lg font-semibold text-grey-100">Cameron Silver</div>
                        <div class="text-grey-500">Commanding Officer</div>
                    </div>
                </div>
                <div class="flex-no-shrink text-grey-600">
                    <app-icon name="edit"></app-icon>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center">
                    <img src="https://api.adorable.io/avatars/114/eee@example.com.png" class="rounded-full h-12 w-12 mr-3">
                    <div class="flex flex-col">
                        <div class="text-lg font-semibold text-grey-100">John Flue</div>
                        <div class="text-grey-500">Yeoman</div>
                    </div>
                </div>
                <div class="flex-no-shrink text-grey-600">
                    <app-icon name="edit"></app-icon>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center">
                    <img src="https://api.adorable.io/avatars/114/ggg@example.com.png" class="rounded-full h-12 w-12 mr-3">
                    <div class="flex flex-col">
                        <div class="text-lg font-semibold text-grey-100">Mel Saunders</div>
                        <div class="text-grey-500">Chief Engineer</div>
                    </div>
                </div>
                <div class="flex-no-shrink text-grey-600">
                    <app-icon name="edit"></app-icon>
                </div>
            </div>

            <div class="flex items-start mt-6">
                <a href="#" class="flex items-center font-medium text-grey-300 bg-grey-700 rounded px-3 py-2 w-full justify-center">
                    View all my characters
                    <app-icon
                        name="arrow-right"
                        class="ml-1"
                        icon-class="h-5 w-5"
                    ></app-icon>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>
