<!-- Modal -->
<div class="modal modal-custom fade" id="editQtyModal" tabindex="-1" role="dialog" aria-labelledby="editQtyModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editQtyModalTitle">Update Product Quantity</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div>
            @include('partials.forms.product-qty-update-form')
          </div>
        </div>
      </div>
    </div>
  </div>