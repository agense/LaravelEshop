@if($discount == 0)
<div class="discount-form">
    <span class="have-code-header">Have A Discount Card ?</span>
    @if ($errors->first('code'))
    <span class="fm-error">{{ $errors->first('code')}}</span>
     @endif
    <div class="have-code-container">
        <form action="{{ route('discountcode.store') }}" method="POST">
            {{ csrf_field() }}
            <input type="text" name="code" id="code" placeholder="Enter Code...">
            <button type="submit" class="button button-dark">Apply</button>
        </form>
    </div>
</div>
@endif