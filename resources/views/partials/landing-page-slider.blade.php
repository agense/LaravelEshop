<div class="hero-slider">
    <!--If discount codes exist, create a slide for each one-->
    @if(isset($slider['promo_slides']))
        @foreach($slider['promo_slides'] as $key => $code)
            <div class="hero-slide-holder">
                <div class="hero-slide">
                @if(checkEven($key))
                    <div class="hero-image">
                        <img src="{{url('img/sale-default-1.png')}}" alt="sale image">
                    </div>
                @else 
                    <div class="hero-image hero-image-ordered">
                        <img src="{{url('img/sale-default-2.png')}}" alt="sale image">
                    </div>
                @endif
                <div class="hero-text-holder">
                    <h1>New Discount Card</h1>
                    <div class="slider-text">
                        <span>Get a {{$code->discount}} discount for all your purchases with code {{$code->code}}!!! </span>
                        <span class="slider-text-subtitle"><i class="fas fa-clock mr-1"></i> Sale Ends On {{$code->expiration_date}}</span>
                    </div>
                </div>
                </div>
            </div>
        @endforeach 
    @endif 
    <!--Dynamic slider-->
    @if(isset($slider['info_slides']))
        @foreach($slider['info_slides'] as $key => $slide)
            <div class="hero-slide-holder">
                <div class="hero-slide">
                    <div class="hero-image {{checkEven($key) ? 'hero-image-ordered' : ''}}">
                        @if($slide->imageExists())
                            <img src="{{url($slide->image_link)}}" alt="slider image">
                        @else
                            <img src="{{url($slide->getDefaultImageLink())}}" alt="slider image">
                        @endif
                    </div>
                    <div class="hero-text-holder">
                        <h1>{{$slide->title}}</h1>
                        <div class="slider-text">
                            <span>{{$slide->subtitle}}</span>
                        </div>
                        <div class="hero-buttons">
                            @if($slide->link)
                            <a href="{{$slide->link}}" class="button button-lg button-white">{{$slide->link_text}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach 
    @endif 