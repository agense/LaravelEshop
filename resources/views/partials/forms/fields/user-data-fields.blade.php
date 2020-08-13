<div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
      @if ($errors->has('email'))
      <span class="fm-error">{{ $errors->first('email')  }}</span>
      @endif
  </div>
  <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name)}}">
      @if ($errors->has('name'))
          <span class="fm-error">{{ $errors->first('name')  }}</span>
      @endif
  </div>
  <div class="form-group">
      <label for="address">Address</label>
      <input type="address" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
      @if ($errors->has('address'))
          <span class="fm-error">{{ $errors->first('address')  }}</span>
      @endif
  </div>
  <div class="half-form">
      <div class="form-group">
          <label for="city">City</label>
          <input type="city" class="form-control" id="city" name="city" value="{{ old('city', $user->city) }}">
          @if($errors->has('city'))
              <span class="fm-error">{{ $errors->first('city')  }}</span>
          @endif
      </div>
      <div class="form-group">
          <label for="region">Region</label>
          <input type="region" class="form-control" id="region" name="region" value="{{ old('region', $user->region) }}">
          @if ($errors->has('region'))
              <span class="fm-error">{{ $errors->first('region')  }}</span>
          @endif
      </div>
  </div>
  <div class="half-form">
      <div class="form-group">
          <label for="postalcode">Postal Code</label>
          <input type="postalcode" class="form-control" id="postalcode" name="postalcode" value="{{ old('postalcode', $user->postalcode) }}">
          @if ($errors->has('postalcode'))
              <span class="fm-error">{{ $errors->first('postalcode')  }}</span>
           @endif
      </div>
      <div class="form-group">
          <label for="phone">Phone</label>
          <input type="phone" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
          @if ($errors->has('phone'))
              <span class="fm-error">{{ $errors->first('phone')  }}</span>
          @endif
      </div>
  </div>      