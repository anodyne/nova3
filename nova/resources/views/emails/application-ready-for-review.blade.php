{{-- format-ignore-start --}}
<x-email-layout>
# Application ready for review

You have been added as a reviewer on an application for **{{ $application->character->name }}**. You can begin reviewing

<x-mail::button :url="route('applications.show', $application)">
Start reviewing &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
