<ol class="relative mb-16 space-y-2" style="counter-reset: step 0">
    <li
        class="relative pb-8 pl-10 before:absolute before:left-0 before:flex before:h-[calc(1.375rem+1px)] before:w-[calc(1.375rem+1px)] before:items-center before:justify-center before:rounded-md before:text-[0.625rem] before:font-bold before:text-gray-700 before:shadow-sm before:ring-1 before:ring-gray-900/5 before:content-[counter(step)] after:absolute after:bottom-0 after:left-[0.6875rem] after:top-[calc(1.875rem+1px)] after:w-px after:bg-gray-200 xl:grid"
        style="counter-increment: step 1"
    >
        <div class="mb-6 xl:mb-0">
            <h4 class="mb-2 text-sm font-semibold leading-6 text-gray-900">Copy the code to the right</h4>
            <div class="prose prose-sm prose-gray">
                <p>You can click anywhere inside the code block to copy it to your clipboard.</p>
            </div>
        </div>
    </li>
    <li
        class="relative pb-8 pl-10 before:absolute before:left-0 before:flex before:h-[calc(1.375rem+1px)] before:w-[calc(1.375rem+1px)] before:items-center before:justify-center before:rounded-md before:text-[0.625rem] before:font-bold before:text-gray-700 before:shadow-sm before:ring-1 before:ring-gray-900/5 before:content-[counter(step)] after:absolute after:bottom-0 after:left-[0.6875rem] after:top-[calc(1.875rem+1px)] after:w-px after:bg-gray-200 xl:grid"
        style="counter-increment: step 1"
    >
        <div class="mb-6 xl:mb-0">
            <h4 class="mb-2 text-sm font-semibold leading-6 text-gray-900">Open your .env file</h4>
            <div class="prose prose-sm prose-gray">
                <p>
                    You can find the file in the root directory of your site. If you don’t see the file, you may have
                    forgotten to upload it to the server. You can grab a copy from the zip archive you downloaded from
                    the Anodyne site.
                </p>
            </div>
        </div>
    </li>
    <li
        class="relative pb-8 pl-10 before:absolute before:left-0 before:flex before:h-[calc(1.375rem+1px)] before:w-[calc(1.375rem+1px)] before:items-center before:justify-center before:rounded-md before:text-[0.625rem] before:font-bold before:text-gray-700 before:shadow-sm before:ring-1 before:ring-gray-900/5 before:content-[counter(step)] after:absolute after:bottom-0 after:left-[0.6875rem] after:top-[calc(1.875rem+1px)] after:w-px after:bg-gray-200 xl:grid"
        style="counter-increment: step 1"
    >
        <div class="mb-6 xl:mb-0">
            <h4 class="mb-2 text-sm font-semibold leading-6 text-gray-900">Replace the database connection values</h4>
            <div class="prose prose-sm prose-gray">
                <p>
                    Near the top of the
                    <code>.env</code>
                    file you’ll find the database connection values. These are the items you’ll want to replace with the
                    values you copied from below.
                </p>
            </div>
        </div>
    </li>
    <li
        class="relative pb-8 pl-10 before:absolute before:left-0 before:flex before:h-[calc(1.375rem+1px)] before:w-[calc(1.375rem+1px)] before:items-center before:justify-center before:rounded-md before:text-[0.625rem] before:font-bold before:text-gray-700 before:shadow-sm before:ring-1 before:ring-gray-900/5 before:content-[counter(step)] after:absolute after:bottom-0 after:left-[0.6875rem] after:top-[calc(1.875rem+1px)] after:w-px after:bg-gray-200 xl:grid"
        style="counter-increment: step 1"
    >
        <div class="mb-6 xl:mb-0">
            <h4 class="mb-2 text-sm font-semibold leading-6 text-gray-900">Save and upload the .env file</h4>
            <div class="prose prose-sm prose-gray">
                <p>
                    Make sure you save the
                    <code>.env</code>
                    file and re-upload it to the root directory of your Nova site.
                </p>
            </div>
        </div>
    </li>
    <li
        class="relative pl-10 before:absolute before:left-0 before:flex before:h-[calc(1.375rem+1px)] before:w-[calc(1.375rem+1px)] before:items-center before:justify-center before:rounded-md before:text-[0.625rem] before:font-bold before:text-gray-700 before:shadow-sm before:ring-1 before:ring-gray-900/5 before:content-[counter(step)] xl:grid"
        style="counter-increment: step 1"
    >
        <div class="mb-6 xl:mb-0">
            <h4 class="mb-2 text-sm font-semibold leading-6 text-gray-900">Verify your database connection</h4>
            <div class="prose prose-sm prose-gray">
                <p>
                    Once you’ve saved the uploaded your
                    <code>.env</code>
                    file, you can verify that Nova can connect to your database.
                </p>

                <x-button.setup type="button" wire:click="verifyDatabase" size="sm">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center" wire:loading.delay.longest>
                            <x-icon.loader class="size-5 animate-spin text-white"></x-icon.loader>
                        </div>
                        <div>Verify database connection</div>
                    </div>
                </x-button.setup>
            </div>
        </div>
    </li>
</ol>
