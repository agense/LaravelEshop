<form action="{{route('user.account.update')}}" method="POST">
    <div class="grid-split">
        <div>
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            @include('partials.forms.fields.user-data-fields')
        </div>

        <div>   
            <h2 class="mini-header">Reset Password</h2>
            <span class="badge">* Leave the fields blank to keep your current password</span>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password">
                @if ($errors->has('password'))
                <span class="fm-error">{{ $errors->first('password')  }}</span>
             @endif
            </div>
            <div class="form-group">
                <label for="password-confirm">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
            </div>    
            <div class="text-right mt-4 mb-5">
                <button type="submit" class="btn-sm btn-dark-sm">Update Account</button>
            </div>
                
        </div>    
    </div>    
</form>