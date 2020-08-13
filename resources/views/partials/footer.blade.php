<!--Footer-->
<footer>
    <div class="footer-top container">
       <div>
           <div class="footer-heading">More</div>
            <ul class="footer-links">
                @foreach($pages as $page)
                    @if($page->type == 'standard')
                    <li><a href="{{route('pages.page.show',$page->slug)}}">{{ucfirst($page->title)}}</a></li>
                    @endif
                @endforeach
            </ul>    
       </div>
       <div>
            <div class="footer-heading">Terms & Conditions</div>
            <ul class="footer-links">
                @foreach($pages as $page)
                    @if($page->type == 'terms')
                    <li><a href="{{route('pages.page.show',$page->slug)}}">{{ucfirst($page->title)}}</a></li>
                    @endif
                @endforeach
            </ul>  
        </div>

       <div>
            <div class="footer-heading">New to our shop ?</div>
            <ul>
                 <li><a href="{{ route('register') }}"><i class="far fa-address-card"></i> <span>Create An Account</span></a></li>
            </ul>
           <div class="footer-heading">Have An Account ?</div>
           <ul>
           <li><a href="{{route('user.account.index')}}"><span><i class="far fa-user mr-1"></i> My Account</span></a></li>
                <li><a href="{{route('user.orders.index')}}"><span><i class="far fa-file mr-1"></i> My Orders</span></a></li>
           </ul>
      </div>
       <div>
        <div class="footer-heading"> Customer Service</div>
        <ul>
            <li class="top-link"><i class="far fa-envelope mr-1"></i> <span>Email</span></li>
            @if($settings->email_primary)
            <li><a href="mailto:{{$settings->email_primary}}"><span>{{$settings->email_primary}}</span></a></li>
            @endif
            @if($settings->email_secondary)
            <li><a href="mailto:{{$settings->email_secondary}}"><span>{{$settings->email_secondary}}</span></a></li>
            @endif

            <li class="top-link mt-2"><i class="fas fa-mobile-alt mr-1"></i> <span>Phone</span></li>
            @if($settings->phone_primary)
            <li><a href="tel:{{$settings->phone_primary}}"><span>{{$settings->phone_primary}}</span></a></li>
            @endif
            @if($settings->phone_secondary)
            <li><a href="tel:{{$settings->phone_secondary}}"><span>{{$settings->phone_secondary}}</span></a></li>
            @endif
        </ul>
        </div> 
    </div>
    <div class="footer-bottom">
        <div>&copy; 2019 | {{ $settings->site_name ?? config('app.name', 'Laravel Ecommerce') }}</div>
    </div>   
</div>
</footer>  
<!--end Footer-->