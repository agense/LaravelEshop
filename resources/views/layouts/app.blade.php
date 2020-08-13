<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings->site_name ?? config('app.name', 'Laravel') }}</title>

    <!--FONTS-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Roboto:100,300,400&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <link href="{{ asset('css/uxwing-iconsfont.min.css') }}" rel='stylesheet'>
    
    <!--Slick Slider-->
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}"/>

    <!--Extra scripts in head-->
    @yield('extra-head')
    <!--Toastr-->
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="front-end">
        @include('partials.navigations.navbar')
        @yield('header')
        
        @yield('content')
        @include('partials/footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!--Extra Scripts-->
    @yield('extra-footer')

    <!--Sweet Alert Library-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!--Toastr-->
    <script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
    <script>
        (function(){
            toastr.options.timeOut = 3500;
            toastr.options.extendedTimeOut = 6000;
            toastr.options.closeButton = true;

            @if(Session::has('success_message'))
                toastr.success("{{Session::get('success_message')}}");
            @endif  
            @if(Session::has('notification'))
                toastr.warning("{{Session::pull('notification')}}");
            @endif
            @if(Session::has('error_message'))
                toastr.error("{{Session::get('error_message')}}");
            @endif           
            //SIDEBAR NAV CONTROL
            const toggler = document.getElementById('user-account-sidebar-toggler');
            const sidenav = document.getElementById('user-account-sidebar');
            toggler.addEventListener('click', function(){
                $(sidenav).slideToggle(300);
            })
        })();    
    </script>
</body>
</html>
