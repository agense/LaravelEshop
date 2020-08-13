<form action="" method="POST" id="admin-form" class="w-100">     
    {{ csrf_field() }}
    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control">
            @foreach($adminRoles as $role)
            <option value="{{$role}}">{{ucfirst($role)}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="name">Full Name</label>
        <input  type="text" name="name" id="name" value="" class="form-control">
    </div>
    <div class="form-group">
        <label for="name">Email</label>
        <input  type="text" name="email" id="email" value="" class="form-control">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input  type="password" name="password" id="password" value="" class="form-control">
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input  type="password" name="password_confirmation" id="password_confirmation" value="" class="form-control">
    </div>
    <div class="text-right mt-5">       
    <button type="submit" class="btn btn-success btn-md dynamic-title">Add New</button>
    </div>
</form>    