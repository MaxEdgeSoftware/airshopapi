@component('mail::message')
# Password Reset
Hello {{$data['name']}}, <br />
You requested to change your account password. <br >
Please contact us on <a href="mail:to='support@airshop247.com'">support@airshop247.com</a> if you did not request for this.

@component('mail::button', ['url' => 'https://airshop247.com/account/change-password?token='.$data['token']])
CLICK TO PROCEED
@endcomponent


@component('mail::panel')
At AIR we make it easier for all businesses to reach more prospects.<br>
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
