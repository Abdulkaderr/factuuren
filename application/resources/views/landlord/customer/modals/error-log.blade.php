<div class="p-t-10 p-b-10">

    <!--log metadata-->
    <table class="table no-border">
        <tbody>
            <tr>
                <td class="text-muted w-30">@lang('lang.date')</td>
                <td class="font-medium">{{ runtimeDate($log->log_created) }}</td>
            </tr>
            <tr>
                <td class="text-muted">@lang('lang.type')</td>
                <td class="font-medium">{{ $log->log_resource_type }}</td>
            </tr>
            <tr>
                <td class="text-muted">@lang('lang.title')</td>
                <td class="font-medium">{{ $log->log_title }}</td>
            </tr>
        </tbody>
    </table>

    <div class="line m-t-10 m-b-20"></div>

    <!--full log body-->
    <div class="x-heading font-weight-bold m-b-10">@lang('lang.description')</div>
    <div class="alert alert-danger">
        {{ $log->log_body }}
    </div>

    <!--notes (if present)-->
    @if($log->log_notes)
    <div class="x-heading font-weight-bold m-b-10 m-t-20">@lang('lang.notes')</div>
    <div class="well">{{ $log->log_notes }}</div>
    @endif

</div>
