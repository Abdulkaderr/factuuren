    <!--converted invoice id (shown when this estimate has been converted to an invoice)-->
    @if($bill->bill_converted_to_invoice == 'yes')
    <div class="pull-right invoice-dues">
        <table>
            <tr>
                <td>{{ cleanLang(__('lang.invoice_id')) }}</td>
                <td>
                    <a href="{{ url('/invoices/'.$bill->bill_converted_to_invoice_invoiceid) }}" class="p-l-20">
                        {{ runtimeInvoiceIdFormat($bill->bill_converted_to_invoice_invoiceid) }}
                    </a>
                </td>
            </tr>
        </table>
    </div>
    @endif
    <!--converted invoice id-->
