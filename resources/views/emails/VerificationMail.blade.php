@component('mail::message')
# ACCOUNT VERIFICATION

Click the button below to verify your account.

@component('mail::button', ['url' => 'https://airshop247.com/verification/'.$data["email"].'/'.$data["token"]])
VERIFY
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent