@props(['settings'])

@php
    $gray = $settings->appearance->getColorShades('gray');
    $primary = $settings->appearance->getColorShades('primary');
    $danger = $settings->appearance->getColorShades('danger');
    $warning = $settings->appearance->getColorShades('warning');
    $success = $settings->appearance->getColorShades('success');
    $info = $settings->appearance->getColorShades('info');
@endphp

<style>
    :root {
        --color-primary-25: {{ $primary::color25->value }};
        --color-primary-50: {{ $primary::color50->value }};
        --color-primary-100: {{ $primary::color100->value }};
        --color-primary-200: {{ $primary::color200->value }};
        --color-primary-300: {{ $primary::color300->value }};
        --color-primary-400: {{ $primary::color400->value }};
        --color-primary-500: {{ $primary::color500->value }};
        --color-primary-600: {{ $primary::color600->value }};
        --color-primary-700: {{ $primary::color700->value }};
        --color-primary-800: {{ $primary::color800->value }};
        --color-primary-900: {{ $primary::color900->value }};

        --color-danger-25: {{ $danger::color25->value }};
        --color-danger-50: {{ $danger::color50->value }};
        --color-danger-100: {{ $danger::color100->value }};
        --color-danger-200: {{ $danger::color200->value }};
        --color-danger-300: {{ $danger::color300->value }};
        --color-danger-400: {{ $danger::color400->value }};
        --color-danger-500: {{ $danger::color500->value }};
        --color-danger-600: {{ $danger::color600->value }};
        --color-danger-700: {{ $danger::color700->value }};
        --color-danger-800: {{ $danger::color800->value }};
        --color-danger-900: {{ $danger::color900->value }};

        --color-warning-25: {{ $warning::color25->value }};
        --color-warning-50: {{ $warning::color50->value }};
        --color-warning-100: {{ $warning::color100->value }};
        --color-warning-200: {{ $warning::color200->value }};
        --color-warning-300: {{ $warning::color300->value }};
        --color-warning-400: {{ $warning::color400->value }};
        --color-warning-500: {{ $warning::color500->value }};
        --color-warning-600: {{ $warning::color600->value }};
        --color-warning-700: {{ $warning::color700->value }};
        --color-warning-800: {{ $warning::color800->value }};
        --color-warning-900: {{ $warning::color900->value }};

        --color-success-25: {{ $success::color25->value }};
        --color-success-50: {{ $success::color50->value }};
        --color-success-100: {{ $success::color100->value }};
        --color-success-200: {{ $success::color200->value }};
        --color-success-300: {{ $success::color300->value }};
        --color-success-400: {{ $success::color400->value }};
        --color-success-500: {{ $success::color500->value }};
        --color-success-600: {{ $success::color600->value }};
        --color-success-700: {{ $success::color700->value }};
        --color-success-800: {{ $success::color800->value }};
        --color-success-900: {{ $success::color900->value }};

        --color-info-25: {{ $info::color25->value }};
        --color-info-50: {{ $info::color50->value }};
        --color-info-100: {{ $info::color100->value }};
        --color-info-200: {{ $info::color200->value }};
        --color-info-300: {{ $info::color300->value }};
        --color-info-400: {{ $info::color400->value }};
        --color-info-500: {{ $info::color500->value }};
        --color-info-600: {{ $info::color600->value }};
        --color-info-700: {{ $info::color700->value }};
        --color-info-800: {{ $info::color800->value }};
        --color-info-900: {{ $info::color900->value }};

        --color-gray-25: {{ $gray::color25->value }};
        --color-gray-50: {{ $gray::color50->value }};
        --color-gray-100: {{ $gray::color100->value }};
        --color-gray-200: {{ $gray::color200->value }};
        --color-gray-300: {{ $gray::color300->value }};
        --color-gray-400: {{ $gray::color400->value }};
        --color-gray-500: {{ $gray::color500->value }};
        --color-gray-600: {{ $gray::color600->value }};
        --color-gray-700: {{ $gray::color700->value }};
        --color-gray-800: {{ $gray::color800->value }};
        --color-gray-900: {{ $gray::color900->value }};
    }
</style>
