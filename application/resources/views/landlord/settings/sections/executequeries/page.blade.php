@extends('landlord.settings.wrapper')
@section('settings_content')

<!--page heading-->
<div class="row page-titles">
    @include('landlord.misc.crumbs')

    <!--select dropdown-->
    <div class="col-md-12 col-lg-7 clearfix p-t-19 text-right">
        <div id="list-page-actions" class="pull-right w-px-300 select-email-template-dropdown">
            <button type="button"
                class="btn btn-sm btn-info waves-effect text-left edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ url('app-admin/settings/execute-queries/create') }}" data-loading-target="commonModalBody"
                data-modal-title="@lang('lang.add_new_query')"
                data-action-url="{{ url('app-admin/settings/execute-queries') }}" data-action-method="POST"
                data-action-ajax-class="ajax-request" data-action-ajax-loading-target="commonModalBody">
                @lang('lang.add_new_query')
            </button>
        </div>
    </div>
</div>


<div class="card m-t-30">
    <div class="card-body">
        @include('landlord.settings.sections.executequeries.table.table')
    </div>
</div>


@endsection