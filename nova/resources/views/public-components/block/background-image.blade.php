@use('Nova\Pages\Enums\BackgroundImageIntensity')

@props([
    'bg',
])

@php
    $bgOption = data_get($bg, 'option');
    $hasBackgroundImage = filled($bgOption) && ! in_array($bgOption, ['color', 'transparent', 'tailwind']);
    $customImage = last(data_get($bg, 'image', []));

    $intensity = BackgroundImageIntensity::tryFrom(data_get($bg, 'intensity', 'none'));
@endphp

@if ($hasBackgroundImage)
    <div class="nv-overlay-ctn absolute inset-0 isolate">
        <img
            src="{{
                match ($bgOption) {
                    'aurora' => asset('dist/pages/aurora.jpg'),
                    'nebula' => asset('dist/pages/nebula.png'),
                    'nebula-blue' => asset('dist/pages/nebula-blue.png'),
                    'nebula-purple' => asset('dist/pages/nebula-purple.png'),
                    'peak' => asset('dist/pages/peak.webp'),
                    'pixels' => asset('dist/pages/pixels.webp'),
                    'ribbon' => asset('dist/pages/ribbon.webp'),
                    'ribbon-full' => asset('dist/pages/ribbon-full.webp'),
                    'stars' => asset('dist/pages/stars.jpg'),
                    'warp' => asset('dist/pages/warp.jpg'),
                    'warp-horizon' => asset('dist/pages/warp-horizon.png'),
                    'warp-illustrated' => asset('dist/pages/warp-illustrated.png'),
                    'warp-intense' => asset('dist/pages/warp-intense.png'),
                    'waves' => asset('dist/pages/waves.webp'),
                    'waves-flat' => asset('dist/pages/waves-flat.webp'),
                    'waves-narrow' => asset('dist/pages/waves-narrow.webp'),
                    'waves-tall' => asset('dist/pages/waves-tall.webp'),
                    'mesh-dark-000' => asset('dist/pages/mesh-dark-000.webp'),
                    'mesh-dark-001' => asset('dist/pages/mesh-dark-001.webp'),
                    'mesh-dark-002' => asset('dist/pages/mesh-dark-002.webp'),
                    'mesh-dark-003' => asset('dist/pages/mesh-dark-003.webp'),
                    'mesh-dark-004' => asset('dist/pages/mesh-dark-004.webp'),
                    'mesh-dark-005' => asset('dist/pages/mesh-dark-005.webp'),
                    'mesh-dark-006' => asset('dist/pages/mesh-dark-006.webp'),
                    'mesh-dark-007' => asset('dist/pages/mesh-dark-007.webp'),
                    'mesh-dark-008' => asset('dist/pages/mesh-dark-008.webp'),
                    'mesh-dark-009' => asset('dist/pages/mesh-dark-009.webp'),
                    'mesh-dark-010' => asset('dist/pages/mesh-dark-010.webp'),
                    'mesh-dark-011' => asset('dist/pages/mesh-dark-011.webp'),
                    'mesh-dark-012' => asset('dist/pages/mesh-dark-012.webp'),
                    'mesh-dark-013' => asset('dist/pages/mesh-dark-013.webp'),
                    'mesh-dark-014' => asset('dist/pages/mesh-dark-014.webp'),
                    'mesh-dark-015' => asset('dist/pages/mesh-dark-015.webp'),
                    'mesh-dark-016' => asset('dist/pages/mesh-dark-016.webp'),
                    'mesh-dark-017' => asset('dist/pages/mesh-dark-017.webp'),
                    'mesh-dark-018' => asset('dist/pages/mesh-dark-018.webp'),
                    'mesh-dark-019' => asset('dist/pages/mesh-dark-019.webp'),
                    'mesh-light-000' => asset('dist/pages/mesh-light-000.webp'),
                    'mesh-light-001' => asset('dist/pages/mesh-light-001.webp'),
                    'mesh-light-002' => asset('dist/pages/mesh-light-002.webp'),
                    'mesh-light-003' => asset('dist/pages/mesh-light-003.webp'),
                    'mesh-light-004' => asset('dist/pages/mesh-light-004.webp'),
                    'mesh-light-005' => asset('dist/pages/mesh-light-005.webp'),
                    'mesh-light-006' => asset('dist/pages/mesh-light-006.webp'),
                    'mesh-light-007' => asset('dist/pages/mesh-light-007.webp'),
                    'mesh-light-008' => asset('dist/pages/mesh-light-008.webp'),
                    'mesh-light-009' => asset('dist/pages/mesh-light-009.webp'),
                    'mesh-light-010' => asset('dist/pages/mesh-light-010.webp'),
                    'mesh-light-011' => asset('dist/pages/mesh-light-011.webp'),
                    'mesh-light-012' => asset('dist/pages/mesh-light-012.webp'),
                    'mesh-light-013' => asset('dist/pages/mesh-light-013.webp'),
                    'mesh-light-014' => asset('dist/pages/mesh-light-014.webp'),
                    'mesh-light-015' => asset('dist/pages/mesh-light-015.webp'),
                    'mesh-light-016' => asset('dist/pages/mesh-light-016.webp'),
                    'mesh-light-017' => asset('dist/pages/mesh-light-017.webp'),
                    'mesh-light-018' => asset('dist/pages/mesh-light-018.webp'),
                    'mesh-light-019' => asset('dist/pages/mesh-light-019.webp'),
                    'custom' => Storage::disk('media-pages')->url($customImage),
                    default => null,
                }
            }}"
            class="h-full w-full object-cover"
            alt=""
        />
        <div
            @class([
                'nv-overlay absolute inset-0 bg-white dark:bg-black',
                $intensity->getTailwindClasses(),
            ])
        ></div>
    </div>
@endif
