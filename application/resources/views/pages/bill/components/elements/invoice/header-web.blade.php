        <!--HEADER-->
        <div class="billing-mode-only-item">
            <span class="pull-left">
                <h3><b>{{ cleanLang(__('lang.invoice')) }}</b>
                    <!--recurring icon-->
                    @include('pages.bill.components.elements.invoice.icons-recuring')
                </h3>
                <span>
                    <h5>#{{ $bill->formatted_bill_invoiceid }}</h5>
                </span>

                <!--module extension point-->
                @stack('bill_position_1')
            </span>
            <span class="pull-right text-align-right">
                <!--status-->
                <span class="js-invoice-statuses" id="invoice-status-draft">
                    <h1 class="text-uppercase text-{{ runtimeInvoiceStatusColors($bill->bill_status, 'text') }}">
                        {{ runtimeInvoiceStatusTitle($bill->bill_status) }}</h1>
                </span>

                <!--module extension point-->
                @stack('bill_position_2')

                @if(config('system.settings_estimates_show_view_status') == 'yes' && (auth()->check() &&
                auth()->user()->is_team) &&
                $bill->bill_status != 1 && $bill->bill_status != 5)
                @if($bill->bill_viewed_by_client == 'no')
                <span>
                    <span
                        class="label label-light-inverse text-lc font-normal">@lang('lang.client_has_not_opened')</span>
                </span>
                @endif
                @if($bill->bill_viewed_by_client == 'yes')
                <span>
                    <span
                        class="label label label-lighter-info text-lc font-normal">@lang('lang.client_has_opened')</span>
                </span>
                @endif
                @endif

                <!--reminder sent-->
                @if((auth()->check() && auth()->user()->is_team) && $bill->bill_status == 3)
                <span>
                    <span
                        class="label label label-light-danger text-lc font-normal">@lang('lang.overdue_reminders_sent')
                        -
                        <span
                            id="invoice_overdue_reminder_counter">{{ $bill->bill_overdue_reminder_counter ?? 0}}</span></span>
                </span>
                @endif
                                <!--module extension point-->
                @stack('bill_position_3')
            </span>
        </div>