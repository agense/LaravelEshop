@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Dashboard</h1>
@endsection
@section('content')
  <div class="grid-2">
    @foreach($data as $dataName => $dataVal)
      @component('components.admin.content-box')
        @slot('title')
          {{formatToText($dataName)}}
        @endslot

        @slot('content')
          <ul class="list-group">
            @foreach($dataVal as $key=>$value)
              @if(is_array($value))
                @foreach($value as $k=>$v)
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if($key == 'ratings')
                      @include('partials.review_partials.star-rating', ['rating' => $k])
                    @else
                    {{formatToText($k)}}
                    @endif 
                      <span class="badge badge-rounded">{{$v}}</span>
                  </li>
                @endforeach
              @else
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{formatToText($key)}}
                <span class="badge badge-rounded">{{$value}}</span>
              </li>
              @endif
            @endforeach
          </ul>
        @endslot
      @endcomponent
    @endforeach
  </div>
@endsection
