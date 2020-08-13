<form action="" method="POST" id="category-form" class="form-inline">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="name">Name</label>
        <input  type="text" name="name" value="" id="name" class="form-control" placeholder="New Category Name">
    </div>
    <button type="submit" class="btn btn-success btn-md">
        <span class="dynamic-title">Add New</span>
    </button>
</form>