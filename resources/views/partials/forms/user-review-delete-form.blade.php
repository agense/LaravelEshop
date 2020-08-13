<form action="{{ route('user.reviews.delete', $review->id) }}" method="POST" class="d-inline item-delete-form">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <input type="hidden" class="confirmation-details" data-item="review" data-text="This action is irreversible. Are you sure you want to delete ths review?">
    <button type="submit" class="btn-sm btn-dark-sm"><i class="fi fi-recycle-bin-line"></i></button>
</form>