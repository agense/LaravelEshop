<form action="" method="POST" id="discountcode-form">     
    {{ csrf_field() }}
    <div class="form-group">
        <label for="code">Code</label>
        <input  type="text" name="code" id="code" value="" class="form-control">
    </div>
    <div class="half-form pt-2">
    <div class="form-group">
            <label for="type">Select Code Type</label>
            <select name="type" id="type" class="form-control">
                @foreach($discountCodeTypes as $type)
                <option value="{{$type}}">{{ucfirst($type)}}</option>
                @endforeach
            </select>
    </div>
    <div class="form-group">
        <label for="value">Value</label>
        <input  type="text" name="value" id="value" value="" class="form-control">
    </div>
    </div>

    <div class="half-form  pt-2">
    <div class="form-group">
        <label for="activation_date">Activation Date</label>
        <input  type="date" name="activation_date" id="activation_date" value="" class="form-control">
    </div>
    <div class="form-group">
        <label for="expiration_date">Expiration Date</label>
        <input  type="date" name="expiration_date" id="expiration_date" value="" class="form-control">
    </div>
    </div>
    <div class="form-group">
        <label for="public">Show As Offer</label>
        <select name="public" id="public" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
        </select>
    </div>
    <div class="text-right mt-5">   
    <button type="submit" class="btn btn-success btn-md dynamic-title">Add new</button>
    </div>
</form>   