        <!--Cart Totals-->
        <div class="checkout-totals mt-3">
            <!-- Cart totals Names -->
            <div class="checkout-totals-left">
                <div>Subtotal</div>
                <!--Discount Section-->
                @if($totals['discount'] !== 0)
                <div>
                    <span>Discount</span>
                    @if(!isset($cartView) && $cartView != true)
                    <!--Remove Discount-->
                        <form action="{{ route('discountcode.destroy') }}" method="POST" class="inline-form">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button type="submit" class="inline-link remove-discount-link"> | Remove Discount</button>
                        </form>
                    @endif
                    <!--End Remove Discount-->
                </div>
                @endif
                <!--End Discount Section-->
                <!--Totals Section-->
                @if($totals['tax_included'])
                    <div class="checkout-totals-total">Total</div>
                    <hr/>
                    <div>Total Before Tax</div>
                    <div>Tax ({{$totals['tax_rate']}}% | included)</div>
                @else 
                    <div>Tax ({{$totals['tax_rate']}}%)</div>
                    <div class="checkout-totals-total">Total</div>
                @endif
                <!--End Totals Section-->
                
            </div>
            <!-- Cart totals Names -->
            <!-- Cart totals Values -->
            <div class="checkout-totals-right">
                <div>{{ formatMoney($totals['initialSubtotal'])}}</div>

                <!--Discount Section-->
                @if($totals['discount'] !== 0)
                    <div>-{{ formatMoney($totals['discount']) }}</div>
                @endif
                <!--End Discount Section-->

                <!--Totals Section-->
                @if($totals['tax_included'])
                    <div class="checkout-totals-total">{{ formatMoney($totals['total']) }}</div>
                    <hr/>
                    <div>{{formatMoney($totals['total_before_tax'])}}</div>
                    <div>{{ formatMoney($totals['tax']) }}</div>
                @else 
                    <div>{{ formatMoney($totals['tax']) }}</div>
                    <div class="checkout-totals-total">{{ formatMoney($totals['total']) }}</div>
                @endif  
                <!--End Totals Section-->  
            </div>
            <!--End Cart Totals Values -->
        </div>   
        <!--End Cart Totals-->