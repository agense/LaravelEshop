<form action="" method="POST" id="feature-form" class="form-inline">
    {{ csrf_field() }}
    <div class="form-group">
        <input  type="text" name="name" id="name" value="" class="form-control" placeholder="New Feature Name">
    </div>
    <button type="submit" class="btn btn-success btn-md">
        <span class="dynamic-title">Add New</span>
    </button>
</form>