@component('mail::message')
# ResetPassWord

Tap this Link to Reset your Password.

@component('mail::button', ['url' => "http://127.0.0.1:8000/api/reset-password/$token"])
ResetPassWord
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
