<div class="modal fade" id="feature-options-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
              <span>Manage Options | <span class="feature-name"></span></span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="modal-content-holder">
            <div class="feature-form-holder mb-4">
              @include('partials.forms.feature-options-form')
            </div>
            <div>OPTIONS</div>
            <div class="separator-narrow"></div>
            <div>
                <div class="feature-options"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>