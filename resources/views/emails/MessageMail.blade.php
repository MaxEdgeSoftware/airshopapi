@component('mail::message')

{!! $data["message"] !!}

<table>
    <tr>
        <td>
            @component('mail::button', ['url' => $data['url']])
            Reply
            @endcomponent
        </td>
        <td>
            @component('mail::button', ['url' => ''])
            Reply
            @endcomponent
        </td>
    </tr>

</table>

Thanks,<br>
{{ config('app.name') }}
@endcomponent