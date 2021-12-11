@component('mail::message')
# ResetPassWord

Tap this Link to Reset your Password.

@component('mail::button', ['url' => "http://13.68.206.72/forgot_password/$token"])
ResetPassWord
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent