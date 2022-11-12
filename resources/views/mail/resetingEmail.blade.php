
@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}
Thank you for choosing to recovery your password !

Click below to start Resetting your password
@component('mail::button', ['url' => $link])
click to redirect
@endcomponent
Sincerely,
Vanga inganzo.
@endcomponent