<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name ?? config('app.name', 'Laravel Ecommerce') }} Admin</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="front-end">
    <div class="auth-holder">  
        <div class="auth-holder-content">
            <div class="auth-content">
                <div class="brand-section">
                    @if($settings->logoExists())
                        <div class="brand-image">
                            <a href="{{url('/')}}" class="brand-link" target="_blank">
                                <img src="{{url($settings->getLogoLink())}}" alt="brand image">
                            </a>
                        </div>
                    @endif
                <h1 class="app-name">{{ $settings->site_name ?? config('app.name', 'Laravel Ecommerce') }}</h1>
                <h2 class="app-subtitle">Administration System</h2>
                </div>
                    @yield('content')
                </div>
            </div>
        <div class="auth-holder-img" style="background-image: url('{{url('/img/hero-photo.jpg')}}');"></div>  
    </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
