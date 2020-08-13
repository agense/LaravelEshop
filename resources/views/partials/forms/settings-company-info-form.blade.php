<form action="{{route('admin.settings.update.company')}}" method="POST">     
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-group">
        <label for="company_name">Company Name</label>
        <input  type="text" name="company_name" id="company_name" value="{{old('company_name') ?? $settings->company_name}}" class="form-control">
        @if ($errors->has('company_name'))
        <span class="fm-error">{{ $errors->first('company_name')}}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="tax_payers_id">Tax Payer Id</label>
        <input  type="text" name="tax_payers_id" id="tax_payers_id" value="{{old('tax_payers_id') ?? $settings->tax_payers_id}}" class="form-control">
        @if ($errors->has('tax_payers_id'))
        <span class="fm-error">{{ $errors->first('tax_payers_id')}}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="email_primary">Email</label>
        <input  type="text" name="email_primary" id="email_primary" value="{{old('email_primary') ?? $settings->email_primary}}" class="form-control">
        @if ($errors->has('email_primary'))
        <span class="fm-error">{{ $errors->first('email_primary')}}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="email_secondary">Additional Email</label>
        <input  type="text" name="email_secondary" id="email_secondary" value="{{old('email_secondary') ?? $settings->email_secondary}}" class="form-control">
        @if ($errors->has('email_secondary'))
        <span class="fm-error">{{ $errors->first('email_secondary')}}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="phone_primary">Phone</label>
        <input  type="text" name="phone_primary" id="phone_primary" value="{{old('phone_primary') ?? $settings->phone_primary}}" class="form-control">
        @if ($errors->has('phone_primary'))
        <span class="fm-error">{{ $errors->first('phone_primary')}}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="email_secondary">Additional Phone</label>
        <input  type="text" name="phone_secondary" id="phone_secondary" value="{{old('phone_secondary') ?? $settings->phone_secondary}}" class="form-control">
        @if ($errors->has('phone_secondary'))
        <span class="fm-error">{{ $errors->first('phone_secondary')}}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="address">Adress</label>
        <input  type="text" name="address" id="address" value="{{old('address') ?? $settings->address}}" class="form-control">
        @if ($errors->has('address'))
        <span class="fm-error">{{ $errors->first('address')}}</span>
        @endif
    </div>
    <div class="text-right mt-4">       
        <button type="submit" class="btn btn-success btn-md">Update Contact Settings</button>
    </div>
</form> 