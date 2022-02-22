<div {{ $attributes->merge(['class' => 'align-middle min-w-full overflow-x-auto']) }}>
    <table class="min-w-full">
        <thead class="border-t border-b border-gray-6">
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody class="bg-gray-1 divide-y divide-gray-6">
            {{ $body }}
        </tbody>
    </table>
</div>