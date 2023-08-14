@props([
  'color' => 'gray',
  'tag' => 'button',
  'type' => 'button',
  'leading' => false,
  'trailing' => false,
  'size' => 'md',
])

<x-button
  :tag="$tag"
  :type="$type"
  :leading="$leading"
  :trailing="$trailing"
  :size="$size"
  {{ $attributes->class([
    'ring-1 ring-inset shadow-sm bg-white dark:bg-gray-900',
    'rounded' => $size === 'xs' || $size === 'sm',
    'rounded-md' => $size === 'md',
    'hover:bg-primary-50 dark:hover:bg-primary-950/50 text-primary-500 dark:text-primary-400 ring-primary-400 dark:ring-primary-700' => $color === 'primary',
    'hover:bg-danger-50 dark:hover:bg-danger-950/30 text-danger-600 dark:text-danger-400 ring-danger-500 dark:ring-danger-700' => $color === 'danger',
    'hover:bg-warning-50 dark:hover:bg-warning-950/30 text-warning-600 dark:text-warning-400 ring-warning-500 dark:ring-warning-700' => $color === 'warning',
    'hover:bg-gray-50 dark:hover:bg-gray-950/50 text-gray-600 dark:text-gray-400 ring-gray-300 dark:ring-gray-700' => $color === 'gray',
  ]) }}
>
  {{ $slot }}
</x-button>