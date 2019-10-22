@extends('layouts.admin')
@section('title')
<h1 class="topnav-heading">Site Settings</h1>
@endsection

@section('content')
<div class="mb-5 row">
<div class="col-lg-10 offset-lg-1 col-md-12">
    <form action="{{route('admin.settings.update')}}" method="POST">     
        {{ csrf_field() }}
        {{ method_field('PUT') }}
    <div class="row">
        <div class="col-md-6">
            <div class="mini-header mb-2">General Settings</div>
            <div class="form-group">
                <label for="site_name">Site Name</label>
                <input  type="text" name="site_name" id="site_name" value="{{old('site_name') ?? $settings->site_name }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="currency">Site Currency</label>
                <select name="currency" id="currency" class="form-control">
                    @foreach($settings->currencyList() as $currency)
                        <option value="{{$currency['code']}}" {{ $currency['code'] == $settings->currency ? "selected" : ""}}>{{$currency['symbol']}} {{ucfirst($currency['name'])}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mini-header mb-2">Contact Settings</div>
                <div class="form-group">
                    <label for="email_primary">Email</label>
                    <input  type="text" name="email_primary" id="email_primary" value="{{old('email_primary') ?? $settings->email_primary}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email_secondary">Additional Email</label>
                    <input  type="text" name="email_secondary" id="email_secondary" value="{{old('email_secondary') ?? $settings->email_secondary}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email_primary">Phone</label>
                    <input  type="text" name="phone_primary" id="phone_primary" value="{{old('phone_primary') ?? $settings->phone_primary}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email_secondary">Additional Phone</label>
                    <input  type="text" name="phone_secondary" id="phone_secondary" value="{{old('phone_secondary') ?? $settings->phone_secondary}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="address">Adress</label>
                    <input  type="text" name="address" id="address" value="{{old('address') ?? $settings->address}}" class="form-control">
                </div>
        </div>
        <div class="col-md-6">
                <div class="mini-header mb-2">Landing Page Slider Settings</div>
                <div class="form-group">
                    <label for="first_slide_title">First Slide Title</label>
                    <input  type="text" name="first_slide_title" id="first_slide_title" value="{{old('first_slide_title') ?? $settings->first_slide_title }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="first_slide_subtitle">First Slide Subtitle</label>
                    <input  type="text" name="first_slide_subtitle" id="first_slide_subtitle" value="{{old('first_slide_subtitle') ?? $settings->first_slide_subtitle }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="first_slide_btn_text">First Slide Button Text</label>
                    <input  type="text" name="first_slide_btn_text" id="first_slide_btn_text" value="{{old('first_slide_btn_text') ?? $settings->first_slide_btn_text }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="first_slide_btn_link">First Slide Button Link</label>
                    <input  type="text" name="first_slide_btn_link" id="first_slide_btn_link" value="{{old('first_slide_btn_link') ?? $settings->first_slide_btn_link }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="second_slide_title">Second Slide Title</label>
                    <input  type="text" name="second_slide_title" id="second_slide_title" value="{{old('second_slide_title') ?? $settings->second_slide_title }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="second_slide_subtitle">Second Slide Subtitle</label>
                    <input  type="text" name="second_slide_subtitle" id="second_slide_subtitle" value="{{old('second_slide_subtitle') ?? $settings->second_slide_subtitle }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="second_slide_btn_text">Second Slide Button Text</label>
                    <input  type="text" name="second_slide_btn_text" id="second_slide_btn_text" value="{{old('second_slide_btn_text') ?? $settings->second_slide_btn_text }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="second_slide_btn_link">Second Slide Button Link</label>
                    <input  type="text" name="second_slide_btn_link" id="second_slide_btn_link" value="{{old('second_slide_btn_link') ?? $settings->second_slide_btn_link }}" class="form-control">
                </div>
            </div> 
        </div>
        <div class="text-right mt-5">       
            <button type="submit" class="btn btn-success btn-md">Update Settings</button>
        </div>
    </form>   
</div>
</div>
@endsection
