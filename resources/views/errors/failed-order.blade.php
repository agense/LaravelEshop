@extends('layouts.app')

@section('content')
<div class="container">
    <div class="message-holder">
        <div class="message">
        <h1 class="mb-4 fm-error">Sorry, your order has failed</h1>
        <div>
            @if ( $errors->count() > 0 )
              @foreach( $errors->all() as $message )
                <p class="fm-error">{{ $message }}</p>
              @endforeach
            </ul>
          @endif
            <p><strong>For assistance, please contact our support team at:</strong></p>
            @if($settings->email_primary)
                <div class="mb-2 text-gray">
                    <i class="far fa-envelope mr-1"></i>
                    <a href="mailto:{{$settings->email_primary}}"><span>{{$settings->email_primary}}</span></a>
                </div>
            @elseif($settings->email_secondary)
                <div class="mb-2 text-gray">
                    <i class="far fa-envelope mr-1"></i>
                    <a href="mailto:{{$settings->email_secondary}}"><span>{{$settings->email_secondary}}</span></a>
                </div>
            @endif
            @if($settings->phone_primary)
                <div class="mb-2 text-gray">
                    <i class="fas fa-mobile-alt mr-1"></i>
                    <a href="tel:{{$settings->phone_primary}}"><span>{{$settings->phone_primary}}</span></a>
                </div>
            @elseif($settings->phone_secondary)
                <div class="mb-2 text-gray">
                    <i class="fas fa-mobile-alt mr-1"></i>
                    <a href="tel:{{$settings->phone_secondary}}"><span>{{$settings->phone_secondary}}</span></a>
                </div>
            @endif
        </div>
        <div class="mt-4">
            <strong class="d-block">Send us an email now</strong>
            <a href="{{route('pages.contact')}}" class="button button-dark">Contact Us</a>
        </div>
    </div>
    </div>
</div>
@endsection