@extends('layouts.app')
@section('content')
<!--Breadcrumbs-->
<div class="breadcrumbs">
        <div class="container-narrow">
        <a href="{{route('landingpage')}}">Home</a>
        <span>></span>
        <a href="{{route('contact.show')}}">Contact</a>
    </div>
    </div>   
<div class="container my-5">
<div class="side-grid">
        <div class="my-3">
        <div class="fm-holder">
            <h1 class="lead-heading mb-4">Send Us A Message</h1>
            <div class="mini-separator-left"></div>
            <form action="{{route('contact.send')}}" method="post">
            {{ csrf_field() }}   
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
               <label for="name">Name</label>
               <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control">
               @if ($errors->has('name'))
               <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
               @endif
            </div>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}" >
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="{{old('email')}}" class="form-control">
                @if ($errors->has('email'))
                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
             </div>
            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="name">Title</label>
                <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control">
                @if ($errors->has('title'))
                <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                <label for="content">Message</label>
                <textarea name="content" id="content" class="form-control">{{old('content')}}</textarea>
                @if ($errors->has('content'))
                <span class="help-block"><strong>{{ $errors->first('content') }}</strong></span>
                @endif
            </div>
            <div>
            <button type="send" class="button button-dark">Send</a>
            </div>
            </form>
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