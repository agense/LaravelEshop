<!--Footer-->
<footer>
    <div class="footer-top container">
       <div>
           <div class="footer-heading">More</div>
            <ul class="footer-links">
                @foreach($standardPageList as $title => $slug)
                    <li><a href="{{route('page.show',$slug)}}">{{ucfirst($title)}}</a></li>
                @endforeach
            </ul>    
       </div>
       <div>
            <div class="footer-heading">Terms & Conditions</div>
            <ul class="footer-links">
                @foreach($termPageList as $title => $slug)
                    <li><a href="{{route('page.show',$slug)}}">{{ucfirst($title)}}</a></li>
                @endforeach
            </ul>  
        </div>

       <div>
            <div class="footer-heading">New to our shop ?</div>
            <ul>
                 <li><a href="{{ route('register') }}"><span>Create an account</span></a></li>
            </ul>
           <div class="footer-heading">Have An Account ?</div>
           <ul>
           <li><a href="{{route('userAccount.index')}}"><span>My Account</span></a></li>
                <li><a href=""><span>My Orders</span></a></li>
           </ul>
      </div>
       <div>
        <div class="footer-heading"> Need Help?</div>
        <ul>
            <li><a href="{{route('contact.show')}}"><i class="far fa-envelope"></i> <span>Contact Us</span></a></li>
            @if($settings->email_primary)
            <li><a href="#"><i class="far fa-envelope"></i> <span>{{$settings->email_primary}}</span></a></li>
            @endif
            @if($settings->email_secondary)
            <li><a href="#"><i class="far fa-envelope"></i> <span>{{$settings->email_secondary}}</span></a></li>
            @endif
            @if($settings->phone_primary)
            <li><a href="#"><i class="fas fa-mobile-alt"></i> <span>{{$settings->phone_primary}}</span></a></li>
            @endif
            @if($settings->phone_secondary)
            <li><a href="#"><i class="fas fa-mobile-alt"></i> <span>{{$settings->phone_secondary}}</span></a></li>
            @endif
        </ul>
        </div> 
    </div>
    <div class="footer-bottom">
        <div> {{ $settings->site_name ?? config('app.name', 'Laravel Ecommerce') }} &copy; 2019</div>
    </div>   
</div>
</footer>  
<!--end Footer-->