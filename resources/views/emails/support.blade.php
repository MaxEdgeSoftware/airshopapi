
@component('mail::message')
New Support request message from {{$data['name']}} <br />

<hr>
{{$data['message']}}. <br>
<hr>


<b>Other Details:</b>
@component('mail::table')
| #       | Info         | Value |
| ------- |:-------------:| --------:|
| 1      | Business Name      | {{$data['businessname']}}      |
| 2      | Fullname      | {{$data['name']}}      |
| 3      | Mobile      | {{$data['phone']}}      |
| 4      | Email      | {{$data['email']}}      |
@endcomponent


@component('mail::panel')
At AIR we make it easier for all businesses to react more prospects.<br>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
