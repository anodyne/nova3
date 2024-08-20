@extends($meta->template)

@php
    $errors = $errors->getBag('default');
@endphp

@section('content')
    <div class="@container nova-advanced-page-content">
        <x-public::h1>Contact</x-public::h1>

        @if (settings('general.contactFormEnabled'))
            @if (session()->has('contact-submitted'))
                <x-public::alert level="success" title="Contact message received" class="mt-8">
                    Your message has been sent and will be reviewed by the staff.
                </x-public::alert>
            @endif

            <x-form :action="route('contact.process')">
                <div class="mt-8 w-full">
                    <x-public::button type="submit" primary>Submit</x-public::button>
                </div>
            </x-form>
        @else
            <x-public::alert level="warning" title="Contact form disabled" class="mt-8">
                {{ settings('general.contactFormDisabledMessage') }}
            </x-public::alert>
        @endif
    </div>
@endsection
