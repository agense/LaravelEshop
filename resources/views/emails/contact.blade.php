@component('mail::message')
<small>You have received a new assistance request via the contact form of {{ config('app.name') }} :</small><br>
<div style="width:100%;padding: 0.25rem 0;border-bottom:1px solid #efefef;"></div><br>

{{$email->title}}<br><br>

{{$email->content}}


@endcomponent
