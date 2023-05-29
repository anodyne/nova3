@props([
  'color' => 'primary',
  'tag' => 'a',
  'type' => 'button',
  'leading' => false,
  'trailing' => false,
  'size' => 'none',
])

<x-button
  :tag="$tag"
  :type="$type"
  :leading="$leading"
  :trailing="$trailing"
  :size="$size"
  {{ $attributes->class([
    'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400' => $color === 'primary',
    'text-danger-500 hover:text-danger-600 dark:hover:text-danger-400' => $color === 'danger',
    'text-gray-600 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-200' => $color === 'dark-gray',
    'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' => $color === 'gray',
    'text-gray-500 dark:text-gray-400 hover:text-primary-500 dark:hover:text-primary-500' => $color === 'gray-primary',
    'text-gray-500 dark:text-gray-400 hover:text-danger-500 dark:hover:text-danger-500' => $color === 'gray-danger',
    'text-gray-400 dark:text-gray-600 hover:text-gray-500 dark:hover:text-gray-500' => $color === 'light-gray',
    'text-gray-400 dark:text-gray-600 hover:text-primary-500 dark:hover:text-primary-500' => $color === 'light-gray-primary',
    'text-gray-400 dark:text-gray-600 hover:text-danger-500 dark:hover:text-danger-500' => $color === 'light-gray-danger',
  ]) }}
>
  {{ $slot }}
</x-button>