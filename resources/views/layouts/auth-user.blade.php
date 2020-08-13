<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name ?? config('app.name', 'Laravel Ecommerce') }}</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Roboto:100,300,400&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/uxwing-iconsfont.min.css') }}" rel='stylesheet'>
</head>
<body>
    <div id="app" class="front-end">
     @include('partials.navigations.navbar')
    <div class="auth-holder user-auth-holder">  
        <div class="auth-holder-content">
            <div class="auth-content">
                    @yield('content')
                </div>
            </div>
        <div class="auth-holder-img" style="background-image: url('{{url('/img/background.jpg')}}');"></div>  
    </div>
    @include('partials/footer')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
