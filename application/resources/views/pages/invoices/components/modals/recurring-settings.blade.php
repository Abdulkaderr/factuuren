<div class="row">
    <div class="col-lg-12">

        <!--repeat period-->
        <div class="form-group row">
            <label for="example-month-input"
                class="col-sm-12 col-lg-3 col-form-label text-left">{{ cleanLang(__('lang.repeat_every')) }}</label>

            <div class="col-sm-12 col-lg-3">
                <input type="number" class="form-control form-control-sm" id="bill_recurring_duration"
                    name="bill_recurring_duration" value="{{ $invoice->bill_recurring_duration ?? 1}}">
            </div>
            <div class="col-6">
                <select class="select2-basic form-control form-control-sm" id="bill_recurring_period"
                    name="bill_recurring_period">
                    <option value="month" {{ runtimePreselected($invoice->bill_recurring_period ?? '', 'month') }}>
                        {{ cleanLang(__('lang.month_months')) }}</option>
                    <option value="day" {{ runtimePreselected($invoice->bill_recurring_period ?? '', 'day') }}>{{ cleanLang(__('lang.days')) }}
                    </option>
                    <option value="week" {{ runtimePreselected($invoice->bill_recurring_period ?? '', 'week') }}>
                        {{ cleanLang(__('lang.week_weeks')) }}</option>
                    <option value="year" {{ runtimePreselected($invoice->bill_recurring_period ?? '', 'year') }}>
                        {{ cleanLang(__('lang.year_years')) }}</option>
                </select>
            </div>

        </div>


        <!--repeat cycle-->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.cycles')) }}</label>
            <div class="col-sm-12 col-lg-3">
                <input type="number" class="form-control form-control-sm" id="bill_recurring_cycles"
                    name="bill_recurring_cycles" value="{{ $invoice->bill_recurring_cycles ?? 0}}">
            </div>
            <div class="col-sm-12 col-lg-3">
                <!--info tooltip-->
                <div class="fx-info-tool-tip">
                    <span class="align-middle text-themecontrast font-16" data-toggle="tooltip"
                        title="{{ cleanLang(__('lang.bill_recurring_period_info')) }}" data-placement="top"><i
                            class="ti-info-alt"></i></span>
                </div>
            </div>
        </div>

        <!--next cycle date-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.next_bill_date')) }}</label> 
            <div class="col-sm-12 col-lg-3">
                @if(isset($invoice['bill_recurring']) && $invoice['bill_recurring'] == 'yes')
                <input type="text" class="form-control form-control-sm pickadate" name="bill_recurring_next"
                    autocomplete="off" value="{{ runtimeDatepickerDate($invoice->bill_recurring_next ?? '') }}">
                <input class="mysql-date" type="hidden" name="bill_recurring_next" id="bill_recurring_next"
                    value="{{ $invoice->bill_recurring_next ?? '' }}">
                @else
                <input type="text" class="form-control form-control-sm pickadate" name="bill_recurring_next"
                    autocomplete="off" value="">
                <input class="mysql-date" type="hidden" name="bill_recurring_next" id="bill_recurring_next" value="">
                @endif
            </div>
            <div class="col-sm-12 col-lg-3">
                <!--info tooltip-->
                <div  class="fx-info-tool-tip">
                    <span class="align-middle text-themecontrast font-16" data-toggle="tooltip"
                        title="{{ cleanLang(__('lang.see_information_below')) }}" data-placement="top"><i
                            class="ti-info-alt"></i></span>
                </div>
            </div>
        </div>

        <!--recurring items table-->
        @if(isset($invoice->lineitems) && count($invoice->lineitems) > 0)
        <div class="form-group row m-t-30">
            <div class="col-12">
                <h6 class="text-left m-b-20">{{ cleanLang(__('lang.recurring')) }} {{ cleanLang(__('lang.items')) }}</h6>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-left" style="width: 150px;">{{ cleanLang(__('lang.recurring')) }}</th>
                                <th class="text-left">{{ cleanLang(__('lang.item')) }}</th>
                                <th class="text-right" style="width: 150px;">{{ cleanLang(__('lang.rate')) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->lineitems->sortBy('lineitem_id') as $lineitem)
                            <tr>
                                <td class="text-left">
                                    <div class="form-group form-group-checkbox m-0">
                                        <div class="p-t-5">
                                            <input type="checkbox"
                                                id="lineitem_recurring_{{ $lineitem->lineitem_id }}"
                                                name="lineitem_recurring_status[{{ $lineitem->lineitem_id }}]"
                                                value="recurring"
                                                class="filled-in chk-col-light-blue"
                                                {{ runtimePrechecked($lineitem->lineitem_recurring_status ?? '', 'recurring') }}>
                                            <label for="lineitem_recurring_{{ $lineitem->lineitem_id }}"></label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-left">{{ $lineitem->lineitem_description }}</td>
                                <td class="text-right">{{ runtimeMoneyFormat($lineitem->lineitem_rate) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!--billing cycles information-->
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                    aria-hidden="true">×</span> </button>
            <h5 class="text-info"><i class="sl-icon-info"></i> {{ cleanLang(__('lang.first_invoice')) }}</h5>
            <div>{{ cleanLang(__('lang.bill_recurring_cycles_explanation_3')) }}</div>
        </div>

        <!--billing cycles information-->
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                    aria-hidden="true">×</span> </button>
            <h5 class="text-info"><i class="sl-icon-info"></i> {{ cleanLang(__('lang.next_bill_date')) }}</h5>
            <div>{{ cleanLang(__('lang.bill_recurring_cycles_explanation_1')) }}</div>
        </div>

        <!--billing cycles information-->
        <div class="alert alert-info hidden">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                    aria-hidden="true">×</span> </button>
            <h5 class="text-info"><i class="sl-icon-info"></i> {{ cleanLang(__('lang.dates_information')) }}</h5>
            <div>{{ cleanLang(__('lang.bill_recurring_cycles_explanation_2')) }}</div>
        </div>


    </div>
</div>