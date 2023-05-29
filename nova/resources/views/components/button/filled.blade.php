@props([
  'color' => 'primary',
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
    'ring-1 ring-inset shadow-sm ring-black/10 dark:ring-white/10 text-white',
    'rounded' => $size === 'xs' || $size === 'sm',
    'rounded-md' => $size === 'md',
    'bg-primary-500 hover:bg-primary-600' => $color === 'primary',
    'bg-danger-500 hover:bg-danger-600' => $color === 'danger',
    'bg-warning-500 hover:bg-warning-600' => $color === 'warning',
  ]) }}
>
  {{ $slot }}
</x-button>