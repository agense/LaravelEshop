<form action="" method="POST" id="add-feature-option-form" class="form-inline">
    {{ csrf_field() }}
    <div class="form-group">
        <input  type="text" name="option" id="option" class="form-control" placeholder="New Option">
    </div>
    <button type="submit" class="btn btn-success btn-md">
        <span>Add New</span>
    </button>
</form>