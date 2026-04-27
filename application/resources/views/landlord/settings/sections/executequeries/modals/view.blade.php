<div>
    <h5 class="mb-3">
        @lang('lang.showing'):
        @if($filter == 'passed')
            @lang('lang.passed_executions')
        @elseif($filter == 'failed')
            @lang('lang.failed_executions')
        @else
            @lang('lang.all_executions')
        @endif
    </h5>

    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>@lang('lang.tenant_domain')</th>
                    <th>@lang('lang.database_name')</th>
                    <th>@lang('lang.date_executed')</th>
                    <th>@lang('lang.status')</th>
                    <th>@lang('lang.errors')</th>
                </tr>
            </thead>
            <tbody>
                @if (@count($logs) > 0)
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->execute_queries_log_tenant_domain }}</td>
                        <td>{{ $log->execute_queries_log_tenant_database }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->execute_queries_log_created)->format('d M Y H:i') }}</td>
                        <td>
                            @if($log->execute_queries_log_status == 'passed')
                                <span class="badge badge-success">@lang('lang.passed')</span>
                            @else
                                <span class="badge badge-danger">@lang('lang.failed')</span>
                            @endif
                        </td>
                        <td>
                            @if($log->execute_queries_log_error)
                                <a href="javascript:void(0);"
                                   class="text-danger view-error-log"
                                   data-error-html="{{ htmlspecialchars($log->execute_queries_log_error) }}">
                                    @lang('lang.view_error')
                                </a>
                            @else
                                ---
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">@lang('lang.no_records_found')</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).on('click', '.view-error-log', function() {
    var errorHtml = $(this).data('error-html');
    var modalHtml = '<div class="error-log-container">' + errorHtml + '</div>';

    $('#commonModalBody').html(modalHtml);
});
</script>
