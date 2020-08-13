@component('components.admin.filter-form', ['targetUrl' => $targetUrl, 'filters' => $filters])
  @slot('left')
    @if((isset($completeView) && $completeView == true))  
       <!--Complete Date-->
       <div class="form-group">
            <label for="complete_date_min">Complete Date From</label>
            <input type="date" id="complete_date_min" name="complete_date_min" class="form-control"
            value="{{array_key_exists('complete_date_min', $filters) ? $filters['complete_date_min'] : ''}}">
        </div>
        
        <div class="form-group">
            <label for="complete_date_max">Complete Date To</label>
            <input type="date" id="complete_date_max" name="complete_date_max" class="form-control"
            value="{{array_key_exists('complete_date_max', $filters) ? $filters['complete_date_max'] : ''}}">
        </div>
       <!--End Complete Date-->
    @else 
      @if(isset($filterOptions))
        @foreach($filterOptions as $name => $options)
          <div class="form-group">
          <label for="{{$name}}">{{formatToText($name)}}</label>
          <select name="{{$name}}" id="{{$name}}" class="form-control">
              <option value=""> -- </option>
              @foreach($options as $key => $val)
              <option value="{{$val}}" {{ (array_key_exists($name, $filters) && $filters[$name] == $val ? "selected=selected" : "")}}> 
              {{$key}} 
              </option>
              @endforeach
          </select>
          </div>
        @endforeach 
      @endif
    @endif
  @endslot

  @slot('middle')
 <!--Order Date-->
    <div class="form-group">
      <label for="order_date_min">Order Date From</label>
      <input type="date" id="order_date_min" name="order_date_min" class="form-control"
      value="{{array_key_exists('order_date_min', $filters) ? $filters['order_date_min'] : ''}}">
    </div>
    
    <div class="form-group">
      <label for="order_date_max">Order Date To</label>
      <input type="date" id="order_date_max" name="order_date_max" class="form-control"
      value="{{array_key_exists('order_date_max', $filters) ? $filters['order_date_max'] : ''}}">
    </div>
    <!--End Order Date-->
  @endslot

  @slot('right')
    <!--Billing Total-->
    <div class="form-group">
        <label for="billing_total_min">Total From</label>
        <input type="number" id="billing_total_min" name="billing_total_min"  min="0" class="form-control"
        value="{{array_key_exists('billing_total_min', $filters) ? $filters['billing_total_min'] : ''}}">
    </div>
    
    <div class="form-group">
        <label for="billing_total_max">Total To</label>
        <input type="number" id="billing_total_max" name="billing_total_max"  min="100" class="form-control"
        value="{{array_key_exists('billing_total_max', $filters) ? $filters['billing_total_max'] : ''}}">
    </div>
  <!--End Billing Total-->
  @endslot
@endcomponent
