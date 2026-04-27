<!--history side panel content-->
<div class="ticket-history-panel">

    <!--user info-->
    <div class="ticket-history-user-info">
        <div class="d-flex align-items-center p-b-15 b-b m-b-15">
            <div class="m-r-10">
                <img src="{{ getUsersAvatar($ticket->avatar_directory, $ticket->avatar_filename) }}"
                    alt="user" width="40" class="img-circle" />
            </div>
            <div class="flex-grow-1">
                <div class="font-bold">{{ $ticket->first_name ?? '' }} {{ $ticket->last_name ?? '' }}</div>
                @if($ticket->client_company_name)
                <div class="text-muted small">{{ $ticket->client_company_name }}</div>
                @endif
                @if($ticket->email)
                <div class="text-muted small">{{ $ticket->email }}</div>
                @endif
            </div>
        </div>
    </div>
    <!--user info-->

    <!--history list-->
    <div id="ticket-history-list">
        @include('pages.ticket.components.misc.history-side-panel-rows')
    </div>
    <!--history list-->

    <!--load more-->
    <div id="ticket-history-load-more-container" class="text-center p-t-20 p-b-10">
        <button type="button"
            id="ticket-history-load-more"
            class="btn btn-rounded-x btn-secondary ajax-request"
            data-ajax-type="GET"
            data-loading-target="ticket-history-list"
            data-url="{{ url('tickets/'.$ticket->ticket_id.'/history?action=load&page=2') }}">
            @lang('lang.load_more')
        </button>
    </div>
    <!--load more-->

</div>
<!--history side panel content-->
