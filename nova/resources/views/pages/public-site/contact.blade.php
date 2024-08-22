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

            <x-form :action="route('public.contact.process')">
                @honeypot

                <div class="max-w-xl space-y-8">
                    <x-public::field.text
                        name="name"
                        label="Name"
                        id="name"
                        :error="$errors->first('name')"
                        value="{{ old('name') }}"
                    ></x-public::field.text>

                    <x-public::field.email
                        name="email"
                        label="Email address"
                        id="email"
                        :error="$errors->first('email')"
                        value="{{ old('email') }}"
                    ></x-public::field.email>

                    <x-public::field.select
                        name="subject"
                        label="Subject"
                        id="subject"
                        :error="$errors->first('subject')"
                    >
                        <option value="General question" @selected(old('subject') === 'General question')>
                            General question
                        </option>
                        <option value="Recruitment" @selected(old('subject') === 'Recruitment')>Recruitment</option>
                        <option value="Site issue" @selected(old('subject') === 'Site issue')>Site issue</option>
                        <option value="Other" @selected(old('subject') === 'Other')>Other</option>
                    </x-public::field.select>

                    <x-public::field.textarea
                        name="message"
                        label="Message"
                        id="message"
                        rows="10"
                        :error="$errors->first('message')"
                    >
                        {{ old('message') }}
                    </x-public::field.textarea>
                </div>

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
