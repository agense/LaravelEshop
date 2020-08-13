@include('partials.admin_partials.table_actions.edit-btn')
@if(!isset($protectedDelete))
    @include('partials.admin_partials.table_actions.delete-form-btn')
@else
    @can('isAdmin')
        @include('partials.admin_partials.table_actions.delete-form-btn')
    @endcan
@endif