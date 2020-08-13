@extends('layouts.admin')
@section('title')
<h1 class="topnav-heading">Slider Settings</h1>
@endsection

@section('content')
@component('components.admin.button-header', ['flex' => true])
<h1 class="md-header">Manage Slides</h1>
<div>
    @include('partials.admin_partials.buttons.direction-btn',['routeUrl' => 'admin.settings.edit', 'text' => 'General Settings'])
    @include('partials.admin_partials.buttons.new-item-btn',['modal'=> true, 'target' => 'sliderFormModal'])
</div>
@endcomponent
<div class="separator pt-0"></div>
<div class="mb-5 row">
    <div class="col-lg-10 offset-lg-1 col-md-12">        
        <div class="grid-2">
        @if($slides->isNotEmpty())
            @foreach($slides as $slide)
                @component('components.admin.content-box')
                    @slot('content')
                        @if($slide->imageExists())
                        <div class="slide-image">
                            <img src="{{url($slide->image_link)}}" alt="slide image">
                        </div>
                        @else 
                        <div class="no-image">
                            <div>No Image</div>
                        </div>
                        @endif
                        <hr/>
                        <div class="slide-content mt-3">
                            <div class="slide-text-box">
                                <span class="slide-text-label">Title</span>
                                <span>{{$slide->title}}</span>
                            </div>
                            <div class="slide-text-box">
                                <span class="slide-text-label">Subtitle</span>
                                <span class="d-block">{{$slide->subtitle}}</span>
                            </div>
                            <div class="slide-text-box">
                                <i class="fas fa-link"></i>
                                <span class="slide-text-label">Link Text</span>
                                <span>{{$slide->link_text}}</span>
                            </div>
                            <div class="slide-text-box">
                                <i class="fas fa-link"></i> <span class="slide-text-label">Link</span>
                                <span>{{$slide->link}}</span>
                            </div>
                        </div>
                        <hr/>
                        <div class="text-center">
                        @can('isAdmin')
                            @include('partials.admin_partials.table_actions.edit-delete', 
                            ['dataId' => $slide->id, 
                            'deleteUrl' => 'admin.settings.slides.destroy',
                            'confirmationText' => [
                                'item' => 'slide',
                                'text' => 'This action is irreversible.']
                            ])
                        @endcan
                        </div>
                    @endslot
                @endcomponent
            @endforeach
        @else
            <div class="no-items">There are no slides</div>
        @endif
        </div>
    </div>
</div>    
<!--Modal-->
@include('partials.modals.form-modal', ['type' => 'slider'])
@endsection

@section('extra-footer')
<script src="{{ asset('js/admin/modal.form.js')}}"></script>
<script>
(function(){
    initModal('sliderFormModal','slider-form', "{{route('admin.settings.slides.index')}}");
})();
</script>
<script src="{{ asset('js/admin/custom-files.js')}}"></script>
@endsection