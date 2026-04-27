<!--options menu-->
<div class="col-sm-12 col-lg-3">
    <div class="card">
        <div class="row">
            <div class="col-lg-12">
                <div class="ticket-panel">
                    <div class="x-top-header">
                        {{ cleanLang(__('lang.ticket_options')) }}
                    </div>
                    <div class="x-body form-horizontal">
                        @if(auth()->user()->is_team)
                        <!--ticket type-->
                        <input type="hidden" name="ticket_type" id="ticket_type" value="client">

                        <!--client container-->
                        <div id="ticket_client_container">
                            <div class="form-group row">
                                <label for="example-month-input" class="col-12 control-label col-form-label text-left required">{{ cleanLang(__('lang.client')) }}</label>
                                <div class="col-12">
                                    <select name="ticket_clientid" id="ticket_clientid" class="clients_and_projects_toggle form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                                        data-projects-dropdown="ticket_projectid" data-feed-request-type="clients_projects"
                                        data-ajax--url="{{ url('/') }}/feed/company_names"></select>
                                </div>
                            </div>
                        </div>

                        <!--new user container-->
                        <div id="ticket_email_container" style="display: none;">
                            <div class="form-group row">
                                <label for="user_name" class="col-12 control-label col-form-label text-left required">
                                    {{ cleanLang(__('lang.full_name')) }}
                                </label>
                                <div class="col-12">
                                    <input type="text" class="form-control form-control-sm" id="user_name"
                                           name="user_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ticket_email" class="col-12 control-label col-form-label text-left required">
                                    {{ cleanLang(__('lang.email_address')) }}
                                </label>
                                <div class="col-12">
                                    <input type="email" class="form-control form-control-sm" id="ticket_email"
                                           name="ticket_email">
                                </div>
                            </div>
                        </div>

                        <!--toggle links-->
                        <div class="form-group row m-t--8" id="ticket_type_toggle_container">
                            <div class="col-12 text-right">
                                <a href="javascript:void(0);" id="ticket_type_toggle_client"
                                   class="ticket-type-toggle active">{{ cleanLang(__('lang.client')) }}</a> |
                                <a href="javascript:void(0);" id="ticket_type_toggle_email"
                                   class="ticket-type-toggle">{{ cleanLang(__('lang.new_user')) }}</a>
                            </div>
                        </div>

                        <div class="line"></div>

                        <!--project container-->
                        <div id="ticket_project_container">
                            <div class="form-group row">
                                <label for="example-month-input" class="col-12 col-form-label text-left">{{ cleanLang(__('lang.project')) }}</label>
                                <div class="col-12">
                                    <select class="select2-basic form-control form-control-sm dynamic_ticket_projectid" id="ticket_projectid" name="ticket_projectid"
                                        disabled>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!--department-->
                        <div class="form-group row">
                            <label for="example-month-input" class="col-12 control-label col-form-label text-left required">{{ cleanLang(__('lang.department')) }}</label>
                            <div class="col-12">
                                <select class="select2-basic form-control  form-control-sm select2-preselected" id="ticket_categoryid" name="ticket_categoryid" data-preselected="9">
                                    <option></option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}">
                                        {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--clients projects-->
                        @if(auth()->user()->is_client)
                        <div class="form-group row">
                            <label for="example-month-input" class="col-12 col-form-label text-left">{{ cleanLang(__('lang.project')) }}</label>
                            <div class="col-12">
                                <select class="select2-basic form-control  form-control-sm" id="ticket_projectid" name="ticket_projectid"
                                    data-allow-clear="true">
                                    <option value=""></option>
                                    @foreach($clients_projects as $project)
                                    <option value="{{ $project->project_id }}">
                                        {{ $project->project_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <!--priority-->
                        @if(auth()->user()->is_team)
                        <div class="form-group row">
                            <label for="example-month-input" class="col-12 col-form-label text-left">{{ cleanLang(__('lang.priority')) }}</label>
                            <div class="col-12">
                                <select class="select2-basic form-control  form-control-sm" id="ticket_priority" name="ticket_priority">
                                    @foreach(config('settings.ticket_priority') as $key => $value)
                                    <option value="{{ $key }}">{{ runtimeLang($key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="line m-t-40 m-b-0"></div>

                        @include('pages.tickets.components.create.customfields')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.ticket-type-toggle {
    font-size: 12px;
    color: #1e88e5;
}
.ticket-type-toggle.active {
    font-weight: bold;
    text-decoration: none;
    color: #333;
}
</style>