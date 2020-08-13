@extends('layouts.admin')
@section('title')
<h1 class="topnav-heading">Site Settings</h1>
@endsection

@section('content')
     @component('components.admin.button-header')
          @include('partials.admin_partials.buttons.direction-btn',['routeUrl' => 'admin.settings.slides.index', 'text' => 'Slider Settings'])
     @endcomponent

<div class="mb-5 row">
<div class="col-md-12">
     <div class="grid-2">
          <div>
               @component('components.admin.content-box')
                    @slot('title')
                         <div class="d-flex justfy-content-center">
                              @if($settings->logoExists())
                              <div class="mini-logo">
                                   <img src="{{url($settings->getLogoLink())}}" alt="logo image">
                              </div>
                              @endif
                         <div class="mini-header">Logo Image</div>
                         </div>
                    @endslot
                    @slot('content')
                         @include('partials.forms.site-logo-upload-form')
                    @endslot
               @endcomponent
               @component('components.admin.content-box')
                    @slot('title')
                    Shop Settings
                    @endslot
                    @slot('content')
                         @include('partials.forms.settings-general-form')  
                    @endslot
               @endcomponent
          </div>
          <div>
               @component('components.admin.content-box')
                    @slot('title')
                         Seller Company Settings
                    @endslot
                    @slot('content')
                         @include('partials.forms.settings-company-info-form')  
                    @endslot
               @endcomponent
          </div>
     </div>
</div>
</div>
@endsection
@section('extra-footer')
<script src="{{ asset('js/admin/custom-files.js')}}"></script>
@endsection
