@foreach($lineitems as $lineitem)
<tr>
    <!--description-->
    <td class="x-description">
        <div class="text-wrap-new-lines">{{ $lineitem->lineitem_description }}
        </div>
        @if(config('system.settings2_invoices_show_long_description') == 'yes' &&
        !empty($lineitem->lineitem_long_description))
        <div class="x-long-description opacity-8 text-wrap-new-lines"><small>{{ $lineitem->lineitem_long_description }}</small></div>
        @endif
        @if($lineitem->item->has_enabled_custom_fields)
        <div class="x-product-custom-fields">
            @foreach($lineitem->item->enabled_custom_fields as $custom_field)
            <div class="x-each-product-custom-fields">
                <small><span class="font-weight-500">{{ $custom_field['name'] }}:</span>
                    {{ $custom_field['value'] }}</small>
            </div>
            @endforeach
        </div>
        @endif
    </td>

    <!--quantity - [plain]-->
    @if($lineitem->lineitem_type == 'plain')
    <td class="x-quantity" style="vertical-align:top;">{{ $lineitem->lineitem_quantity }}</td>
    @endif

    <!--quantity -[time]-->
    @if($lineitem->lineitem_type == 'time')
    <td class="x-quantity" style="vertical-align:top;">
        @if($lineitem->lineitem_time_hours > 0)
        {{ $lineitem->lineitem_time_hours }}{{ strtolower(__('lang.hrs')) }}&nbsp;
        @endif
        @if($lineitem->lineitem_time_minutes > 0)
        {{ $lineitem->lineitem_time_minutes }}{{ strtolower(__('lang.mins')) }}
        @endif
    </td>
    @endif

    <!--quantity - [dimensions]-->
    @if($lineitem->lineitem_type == 'dimensions')
    <td class="x-quantity">{{ $lineitem->lineitem_quantity }}</td>
    @endif

    <!--unit price-->
    <td class="x-unit">{{ $lineitem->lineitem_unit }}</td>
    <!--rate-->
    <td class="x-rate">{{ runtimeNumberFormat($lineitem->lineitem_rate) }}</td>
    <!--discount-->
    <td
        class="x-discount bill_col_discount {{ runtimeVisibility('invoice-column-inline-discount', $bill->bill_tax_type) }}">
        @if($lineitem->lineitem_discount_type == 'fixed')
        {{ runtimeMoneyFormat($lineitem->lineitem_discount_value) }}
        @elseif($lineitem->lineitem_discount_type == 'percentage')
        {{ runtimeNumberFormat($lineitem->lineitem_discount_value) }}%
        @else
        {{ runtimeMoneyFormat(0) }}
        @endif
    </td>
    <!--tax rate (inline mode only)-->
    <td class="x-tax-rate bill_col_tax_rate {{ runtimeVisibility('invoice-column-inline-tax', $bill->bill_tax_type) }}">
        @foreach($lineitem->taxes as $tax)
        <div>{{ runtimeDecimalFloat($tax->tax_rate) }}%</div>
        <div class="tax-rate-name font-10">({{ $tax->tax_name }})</div>
        @endforeach
    </td>
    <!--tax-->
    <td class="x-tax bill_col_tax_amount {{ runtimeVisibility('invoice-column-inline-tax', $bill->bill_tax_type) }}">
        {{ runtimeNumberFormat($lineitem->lineitem_tax_amount) }}
    </td>
    <!--total-->
    <td class="x-total bill_col_gross_total text-right">{{ runtimeNumberFormat($lineitem->lineitem_total) }}</td>
    <!--net total-->
    <td class="x-net-total bill_col_net_total text-right">{{ runtimeNumberFormat($lineitem->net_line_total) }}</td>
</tr>
@endforeach