@props(['settings'])

<style>
    :root {
        @foreach ($settings->appearance->getColors() as $key => $palette)
            @foreach ($palette as $shade => $color)
                --color-{{ $key }}-{{ $shade }}: {{ $color }};
            @endforeach
        @endforeach
    }
</style>
