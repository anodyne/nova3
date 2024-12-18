@props([
    'startColor' => '#4ade80',
    'stopColor' => '#14b8a6',
])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" {{ $attributes }}>
    <defs>
        <linearGradient id="d" gradientTransform="rotate(90)">
            <stop offset="5%" stop-color="{{ $startColor }}" />
            <stop offset="100%" stop-color="{{ $stopColor }}" />
        </linearGradient>
    </defs>
    <path
        d="M23.74 3.16a1 1 0 0 0 -0.6 -0.76 1 1 0 0 0 -1 0.1 13.5 13.5 0 0 1 -7.66 2C8.34 4.45 5.76 7 5.71 7a8.11 8.11 0 0 0 -3.28 6.49A8 8 0 0 0 3 16.57a0.51 0.51 0 0 1 -0.1 0.53L0.27 20a1 1 0 0 0 0 1.42 1 1 0 0 0 1.32 0.05C3.35 19.9 6.15 15.2 14 11.91a1 1 0 0 1 0.78 1.86 26.18 26.18 0 0 0 -8.43 5.54l-0.24 0.25A0.51 0.51 0 0 0 6 20a0.5 0.5 0 0 0 0.24 0.36 8 8 0 0 0 4.26 1.22A12.21 12.21 0 0 0 16.27 20C25 15.17 24.2 5.89 23.74 3.16Z"
        fill="url(#d)"
        stroke-width="1"
    ></path>
</svg>
