<div class="row">
    <div class="col-lg-12">
        <div class="p-b-30">

            <table class="table table-bordered payment-details">
                <tbody>
                    <tr>
                        <td>{{ cleanLang(__('lang.refund_id')) }}</td>
                        <td>{{ runtimeRefundIdFormat($refund->refund_id) }}</td>
                    </tr>
                    <tr>
                        <td>{{ cleanLang(__('lang.refund_date')) }}</td>
                        <td>{{ runtimeDate($refund->refund_date) }}</td>
                    </tr>
                    <tr class="font-16 font-weight-600">
                        <td>{{ cleanLang(__('lang.amount')) }}</td>
                        <td>{{ runtimeMoneyFormat($refund->refund_amount) }}</td>
                    </tr>
                    <tr>
                        <td>{{ cleanLang(__('lang.payment_method')) }}</td>
                        <td>{{ $refund->payment->payment_gateway ?? '---' }}</td>
                    </tr>
                    @if(auth()->user()->is_team)
                    <tr>
                        <td>{{ cleanLang(__('lang.client')) }}</td>
                        <td>{{ $refund->client->client_company_name ?? '---' }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>{{ cleanLang(__('lang.invoice')) }}</td>
                        <td>{{ runtimeInvoiceIdFormat($refund->refund_invoiceid) }}</td>
                    </tr>
                    <tr>
                        <td>{{ cleanLang(__('lang.notes')) }}</td>
                        <td>{{ $refund->refund_notes ?? '' }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
