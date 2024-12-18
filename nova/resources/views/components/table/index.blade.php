<div {{ $attributes->merge(['class' => 'align-middle min-w-full overflow-x-auto']) }}>
    <table class="min-w-full">
        <thead class="border-b border-t border-gray-950/5 dark:border-white/5">
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-950/5 bg-white dark:divide-white/5">
            {{ $body }}
        </tbody>
    </table>
</div>
