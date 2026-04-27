<!--history rows-->
@forelse($history_tickets as $history_ticket)
<div class="ticket-history-item p-b-10 m-b-10 b-b">
    <div class="m-b-5">
        <a href="{{ url('tickets/'.$history_ticket->ticket_id) }}" class="font-medium" target="_blank">
            {{ str_limit($history_ticket->ticket_subject, 60) }}
        </a>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ runtimeDate($history_ticket->ticket_created) }}</small>
        <span class="label label-outline-{{ $history_ticket->ticketstatus_color }}">
            {{ runtimeLang($history_ticket->ticketstatus_title) }}
        </span>
    </div>
</div>
@empty
<div class="page-notification">
    <h5>@lang('lang.no_ticket_history')</h5>
</div>
@endforelse
<!--history rows-->
