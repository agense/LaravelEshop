<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings->site_name ?? config('app.name', 'Laravel Ecom') }} Admin</title>

    <!-- Styles -->
    <!--Slick Slider-->
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}"/>

    <!--Fonts-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset('css/uxwing-iconsfont.min.css') }}" rel='stylesheet'>

    <!--Toastr-->
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}"/>

    <!--Main css file--> 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--Extra scripts in head-->
    @yield('extra-head')
</head>
<body>
    <div id="app" class="front-end">
        <div class="container-fluid">
           <div class="row template-grid">
            <div class="sidebar-nav" id="sidebar-nav">   
                @include('partials.admin-sidebar-nav') 
            </div>
            <div class="main-page" id="content-display">
                @include('partials.admin-top-nav') 
                <div class="main-content">
                <!--Error Display-->
                @if($errors->any())
                    <div class="alert alert-danger">
                    <ul>
                      @foreach($errors->all() as $error)
                      <li>{{$error}}</li>
                      @endforeach
                    </ul>
                    </div>
                @endif
                @yield('content')
                </div>
            </div>
           </div>
        </div>   
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!--Extra Scripts-->
    @yield('extra-footer')

    <!--Slick Slider-->
    <script type="text/javascript" src="{{ asset('js/slick.min.js') }}"></script>
    <!--Toastr-->
    <script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
    <!--Admin Control JS-->
    <script type="text/javascript" src="{{ asset('js/admin.main.js') }}"></script>

    <script>
    //Toast Messages
        toastr.options.timeOut = 3000;
        toastr.options.extendedTimeOut = 6000;
        toastr.options.closeButton = true;
        @if(Session::has('success_message'))
            toastr.success("{{Session::get('success_message')}}");
        @endif  
        
        @if(Session::has('info_message'))
            toastr.success("{{Session::get('info_message')}}");
        @endif 

        @if(Session::has('error_message'))
            toastr.error("{{Session::get('error_message')}}");
        @endif  
    </script>
</body>
</html>
