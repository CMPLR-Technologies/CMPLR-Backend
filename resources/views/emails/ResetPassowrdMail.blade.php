@component('mail::message')
# ResetPassWord

Tap this Link to Reset your Password.

@component('mail::button', ['url' => env('APP_URL') . "/forgot_password/$token"])
ResetPassWord
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent