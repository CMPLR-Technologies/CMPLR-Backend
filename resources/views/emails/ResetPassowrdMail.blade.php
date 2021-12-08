@component('mail::message')
# ResetPassWord

Tap this Link to Reset your Password.

@component('mail::button', ['url' => "https://www.tumblr.com/forgot_password/$token"])
ResetPassWord
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
