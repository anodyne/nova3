{{-- format-ignore-start --}}
<x-mail::layout>
<x-slot:header>
<x-mail::header url="{{ config('app.url') }}">
@if (filled($logo))
<img src="data:image/png;base64,{{ $logo }}" class="logo" alt="">
@else
<h1>{{ $gameName }}</h1>
@endif
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

<x-slot:footer>
<x-mail::footer>
This is an automated email sent by Nova
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
{{-- format-ignore-end --}}
