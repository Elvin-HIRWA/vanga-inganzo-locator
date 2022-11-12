@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}
Follow the guide to signup to Vanga Inganzo Entertainments Locator !

Click below to start Sign up 
@component('mail::button', ['url' => $link])
click to redirect
@endcomponent
Sincerely,
vangainganzo team.
@endcomponent