@use('Nova\Forms\Models\Form')

@php
    $formModel = Form::key($form)->first();
@endphp

<div
    @class([
        '@container',
        'nv-form',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <x-public::block.header
            :heading="$heading ?? null"
            :description="$description ?? null"
            :orientation="$headerOrientation"
        ></x-public::block.header>

        <div
            @class([
                'w-full',
                'mx-auto' => $formOrientation === 'center',
                match ($formWidth ?? null) {
                    'lg' => 'max-w-lg',
                    'xl' => 'max-w-xl',
                    '2xl' => 'max-w-2xl',
                    '3xl' => 'max-w-3xl',
                    '4xl' => 'max-w-4xl',
                    default => 'max-w-none',
                } => filled($formWidth),
                'mt-12' => filled($heading) || filled($description),
            ])
        >
            <livewire:dynamic-form :form="$formModel" />
        </div>
    </x-public::block.wrapper>
</div>
