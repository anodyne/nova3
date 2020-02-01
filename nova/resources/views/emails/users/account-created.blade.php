@component('mail::message')
# Introduction

An account has been created for you.

We recommend that you reset the generated password to something you can remember.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
