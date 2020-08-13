<form action="{{route('admin.settings.update.general')}}" method="POST">     
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-group">
        <label for="site_name">Shop Name</label>
        <input  type="text" name="site_name" id="site_name" value="{{old('site_name') ?? $settings->site_name }}" class="form-control">
        @if ($errors->has('site_name'))
        <span class="fm-error">{{ $errors->first('site_name')  }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="currency">Currency</label>
        <select name="currency" id="currency" class="form-control">
            @foreach($settings->currencyList() as $currency)
                <option value="{{$currency['code']}}" {{ $currency['code'] == $settings->currency ? "selected" : ""}}>{{$currency['symbol']}} {{ucfirst($currency['name'])}}</option>
            @endforeach
        </select>
        @if ($errors->has('currency'))
        <span class="fm-error">{{ $errors->first('currency')}}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="tax_rate">Tax Rate(%)</label>
        <small class="d-block form-helper-note">*Enter tax rate as percentage, for example, 21.5 for 21.5%</small>
        <input  type="text" name="tax_rate" id="tax_rate" value="{{old('tax_rate') ?? $settings->tax_rate }}" class="form-control">
        @if ($errors->has('tax_rate'))
        <span class="fm-error">{{ $errors->first('tax_rate')  }}</span>
        @endif
    </div>
    <div class="form-group">
        <span class="add-on-label">Tax Included</span>
        <small class="d-block form-helper-note">*If tax is not included, it will be added to the total on checkout.</small>
        @foreach($taxOptions as $name => $value)
        <div class="bordered-radio">
            <?php 
                $checked = old('tax_included') ?? $settings->tax_included;
             ?>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="tax_included" 
                id="{{$value}}" value="{{$value}}" {{ ($checked == $value) ? 'checked' : ''}}>
                <label class="custom-control-label" for="{{$value}}">
                  {{$name}}
                </label>
            </div>
        </div>
        @endforeach 
        @if ($errors->has('tax_included'))
        <span class="fm-error">{{ $errors->first('tax_included')  }}</span>
        @endif
    </div>
    <div class="text-right mt-4">       
        <button type="submit" class="btn btn-success btn-md">Update Settings</button>
    </div>
</form> 