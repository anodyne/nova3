<div {{ $attributes->merge(['class' => 'align-middle min-w-full overflow-x-auto']) }}>
    <table class="min-w-full">
        <thead class="border-t border-b border-gray-200 dark:border-gray-700">
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
            {{ $body }}
        </tbody>
    </table>
</div>
