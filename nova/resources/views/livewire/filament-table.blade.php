<div @class([
    'fi-ta-simple' => $simple && ! $rounded,
    'fi-ta-simple-rounded' => $simple && $rounded,
])>
    {{ $this->table }}
</div>
