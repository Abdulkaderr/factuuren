<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex m-b-30">
                    <h5 class="card-title m-b-0 align-self-center">{{ cleanLang(__('lang.new_customers')) }}</h5>
                    <div class="ml-auto align-self-center">
                        <ul class="list-inline font-12">
                            <li><span class="label label-success label-rounded"><i class="fa fa-circle"></i>
                                    {{ $payload['customers']['year'] }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="incomeexpenses campaign ct-charts" id="admin-dashboard-customers-chart"></div>
                <div class="row text-center">
                    <div class="col-lg-6 col-md-6 m-t-20">
                        <h2 class="m-b-0 font-light">{{ $payload['customers']['year'] }}</h2>
                        <small>{{ cleanLang(__('lang.period')) }}</small>
                    </div>
                    <div class="col-lg-6 col-md-6 m-t-20">
                        <h2 class="m-b-0 font-light">{{ $payload['customers']['total'] }}</h2>
                        <small>{{ cleanLang(__('lang.new_customers')) }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--[DYNAMIC INLINE SCRIPT] - Backend Variables to Javascript Variables-->
<script>
    NX.saas_home_chart_customers = JSON.parse('{!! json_encode(_clean($payload["customers"]["monthly"])) !!}', true);
</script>

<script src="/public/js/landlord/dynamic/home.customers.stats.js?v={{ config('system.versioning') }}"></script>
