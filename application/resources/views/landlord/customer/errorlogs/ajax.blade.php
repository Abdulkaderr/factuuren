@foreach($logs as $log)
<!--each row-->
<tr id="error_log_{{ $log->log_id }}">

    <!--date-->
    <td>{{ runtimeDate($log->log_created) }}</td>

    <!--log type-->
    <td>{{ $log->log_resource_type }}</td>

    <!--description (truncated for the table view)-->
    <td>{{ \Illuminate\Support\Str::limit($log->log_title, 80) }}</td>

    <!--actions-->
    <td class="actions_column">
        <a href="javascript:void(0);"
            class="btn btn-sm btn-outline-info ajax-request edit-add-modal-button"
            title="@lang('lang.view_log')"
            data-toggle="modal"
            data-target="#commonModal"
            data-loading-target="commonModalBody"
            data-modal-title="@lang('lang.error_log')"
            data-url="{{ url('app-admin/customers/'.$customer->tenant_id.'/error-logs/'.$log->log_id) }}"
            data-footer-visibility="hidden">
            @lang('lang.view_log')
        </a>
    </td>

</tr>
<!--/each row-->
@endforeach
