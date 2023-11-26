{{-- format-ignore-start --}}
<x-mail::layout>
<x-slot:header>
<x-mail::header url="{{ config('app.url') }}">
<img src="data:image/png;base64,{{ $logo }}" class="logo" alt="">
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
Click here to unsubscribe from these emails
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
{{-- format-ignore-end --}}
