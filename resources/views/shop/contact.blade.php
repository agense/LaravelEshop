@extends('layouts.app')
@section('content')
<!--Breadcrumbs-->
<div class="breadcrumbs">
        <div class="container-narrow">
        <a href="{{route('pages.landing')}}">Home</a>
        <span>></span>
        <a href="{{route('pages.contact')}}">Contact</a>
    </div>
    </div>   
<div class="container my-5">
<div class="side-grid">
        <div class="my-3">
        <div class="fm-holder shadow-box">
            <h2 class="md-header contact-form-header">Send Us A Message</h1>
            @include('partials.forms.contact-form')
        </div>
        </div>
        <div class="my-3 contact-details">
            <h2 class="md-header">Need Help?  Contact us</h2>
           <div class="gray mb-5">Our customer service will be happy to assist you.</div>
            <div class="contact-info">
                    @if($settings->email_primary || $settings->email_secondary)
                    <div class="contact-box">
                        <div class="contact-box-icon"><i class="far fa-envelope"></i></div>
                        <div class="contact-box-content">
                            @if($settings->email_primary)
                             <a href="#">{{$settings->email_primary}}</a>
                            @endif
                            @if($settings->email_secondary)
                            <a href="#">{{$settings->email_secondary}}</a>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($settings->phone_primary || $settings->phone_secondary)
                    <div class="contact-box">
                        <div class="contact-box-icon"><i class="fas fa-mobile-alt"></i></div>
                        <div class="contact-box-content">
                            @if($settings->phone_primary)
                             <a href="#">{{$settings->phone_primary}}</a>
                            @endif
                            @if($settings->email_secondary)
                            <a href="#">{{$settings->phone_secondary}}</a>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($settings->address)
                    <div class="contact-box">
                        <div class="contact-box-icon"><i class="fas fa-map-marker"></i></div>
                        <div class="contact-box-content">
                           <span>{{$settings->address}}</span>
                        </div>
                    </div>
                    @endif
            </div>
        </div>
</div>
</div>
@endsection