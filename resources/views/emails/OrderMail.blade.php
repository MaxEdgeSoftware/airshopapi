@component('mail::message')
# Dear Vendor,

New Order has been received

@component('mail::button', ['url' => 'https://airshop247.com/account/login'])
Login to view order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
