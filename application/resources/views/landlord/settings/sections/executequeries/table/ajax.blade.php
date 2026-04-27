@foreach($queries as $query)
<tr id="query_{{ $query->execute_query_uniqueid }}">
    <td>{{ \Carbon\Carbon::parse($query->execute_query_created)->format('d M Y') }}</td>
    <td>{{ $query->execute_query_uniqueid }}</td>
    <td>{{ $query->execute_query_description }}</td>
    <td>
        <a href="javascript:void(0);"
           class="edit-add-modal-button js-ajax-ux-request reset-target-modal-form query-count-link"
           data-toggle="modal"
           data-target="#commonModal"
           data-url="{{ url('app-admin/settings/execute-queries/' . $query->execute_query_uniqueid . '/logs?filter=passed') }}"
           data-loading-target="commonModalBody"
           data-modal-title="@lang('lang.execution_logs')"
           data-action-ajax-class=""
           data-action-ajax-loading-target="commonModalBody">
            {{ $query->passed_count }}
        </a>
    </td>
    <td>
        <a href="javascript:void(0);"
           class="edit-add-modal-button js-ajax-ux-request reset-target-modal-form query-count-link text-danger"
           data-toggle="modal"
           data-target="#commonModal"
           data-url="{{ url('app-admin/settings/execute-queries/' . $query->execute_query_uniqueid . '/logs?filter=failed') }}"
           data-loading-target="commonModalBody"
           data-modal-title="@lang('lang.execution_logs')"
           data-action-ajax-class=""
           data-action-ajax-loading-target="commonModalBody">
            {{ $query->failed_count }}
        </a>
    </td>
    <td>
        <a href="javascript:void(0);"
           class="edit-add-modal-button js-ajax-ux-request reset-target-modal-form query-count-link"
           data-toggle="modal"
           data-target="#commonModal"
           data-url="{{ url('app-admin/settings/execute-queries/' . $query->execute_query_uniqueid . '/logs?filter=all') }}"
           data-loading-target="commonModalBody"
           data-modal-title="@lang('lang.execution_logs')"
           data-action-ajax-class=""
           data-action-ajax-loading-target="commonModalBody">
            {{ $query->total_count }}
        </a>
    </td>
    <td>
        @if($query->execute_query_status == 'draft')
            <span class="label label-default">@lang('lang.draft')</span>
        @elseif($query->execute_query_status == 'active')
            <span class="label label-success">@lang('lang.active')</span>
        @elseif($query->execute_query_status == 'processing')
            <span class="label label-primary">@lang('lang.processing')</span>
        @elseif($query->execute_query_status == 'paused')
            <span class="label label-warning">@lang('lang.paused')</span>
        @elseif($query->execute_query_status == 'completed')
            <span class="label label-info">@lang('lang.completed')</span>
        @endif
    </td>
    <td class="actions_column">
        <span class="list-table-action dropdown font-size-inherit">
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_query')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                data-ajax-type="DELETE"
                data-url="{{ url('app-admin/settings/execute-queries/' . $query->execute_query_uniqueid) }}">
                <i class="sl-icon-trash"></i>
            </button>
            <span class="list-table-action dropdown" style="font-size: inherit;">
                <button type="button" id="listTableAction_{{ $query->execute_query_uniqueid }}"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    class="btn btn-outline-default btn-circle btn-sm">
                    <i class="sl-icon-note"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="listTableAction_{{ $query->execute_query_uniqueid }}">
                    @if(in_array($query->execute_query_status, ['draft', 'paused']))
                    <a href="javascript:void(0);"
                       class="dropdown-item ajax-request"
                       data-url="{{ url('app-admin/settings/execute-queries/' . $query->execute_query_uniqueid . '/status?status=active') }}"
                       data-ajax-type="get"
                       data-loading-target="body">
                        @lang('lang.activate')
                    </a>
                    @endif
                    @if($query->execute_query_status == 'active')
                    <a href="javascript:void(0);"
                       class="dropdown-item ajax-request"
                       data-url="{{ url('app-admin/settings/execute-queries/' . $query->execute_query_uniqueid . '/status?status=paused') }}"
                       data-ajax-type="get"
                       data-loading-target="body">
                        @lang('lang.pause')
                    </a>
                    @endif
                </div>
            </span>
        </span>
    </td>
</tr>
@endforeach
