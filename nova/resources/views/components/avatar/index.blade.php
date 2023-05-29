@props([
  'src',
  'size' => 'md',
  'tooltip' => '',
])

<img
  src="{{ $src }}"
  alt="{{ $tooltip }}"
  {{ $attributes->class([
    'inline-block relative rounded-full bg-white dark:bg-gray-900 ring-2 ring-white dark:ring-gray-900',
    'h-8 w-8' => $size === 'xs',
    'h-10 w-10' => $size === 'sm',
    'h-12 w-12' => $size === 'md',
    'h-16 w-16' => $size === 'lg',
    'h-24 w-24' => $size === 'xl',
  ])}}
>
