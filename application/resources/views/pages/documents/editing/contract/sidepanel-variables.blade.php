<!-- right-sidebar -->
<div class="right-sidebar documents-side-panel-variables sidebar-lg" id="documents-side-panel-variables">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <!--add class'due'to title panel -->
                <i class="ti-write display-inline-block m-t--5"></i>
                <div class="display-inline-block">
                    @lang('lang.variables')
                </div>
                <span>
                    <i class="ti-close js-close-side-panels" data-target="documents-side-panel-variables"
                        id="documents-side-panel-variables-close-icon"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body documents-side-panel-variables-body  p-b-80"
                id="documents-side-panel-variables-body">

                <div class="alert alert-info">
                    @lang('lang.variables_instruction')
                </div>

                <div class="table-responsive p-b-30">
                    <table class="table table-bordered table-sm m-t-20">
                        <tbody>
                            <tr>
                                <td colspan="2" class="bg-contrast font-weight-bold p-2">@lang('lang.standard_fields')</td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.company_name')</td>
                                <td class="p-2"><code>{company_name}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.client_company_name')</td>
                                <td class="p-2"><code>{client_company_name}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.first_name')</td>
                                <td class="p-2"><code>{client_first_name}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.last_name')</td>
                                <td class="p-2"><code>{client_last_name}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.email')</td>
                                <td class="p-2"><code>{client_email}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.phone')</td>
                                <td class="p-2"><code>{client_phone}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.street')</td>
                                <td class="p-2"><code>{client_street}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.city')</td>
                                <td class="p-2"><code>{client_city}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.state')</td>
                                <td class="p-2"><code>{client_state}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.zipcode')</td>
                                <td class="p-2"><code>{client_zip}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.country')</td>
                                <td class="p-2"><code>{client_country}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.website')</td>
                                <td class="p-2"><code>{client_website}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.contract_id')</td>
                                <td class="p-2"><code>{contract_id}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.contract_title')</td>
                                <td class="p-2"><code>{contract_title}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.contract_date')</td>
                                <td class="p-2"><code>{contract_date}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.contract_end_date')</td>
                                <td class="p-2"><code>{contract_end_date}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.contract_value')</td>
                                <td class="p-2"><code>{contract_value}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.prepared_by')</td>
                                <td class="p-2"><code>{prepared_by_name}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.pricing_table')</td>
                                <td class="p-2"><code>{pricing_table}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.pricing_table_total')</td>
                                <td class="p-2"><code>{pricing_table_total}</code></td>
                            </tr>
                            <tr>
                                <td class="p-2">@lang('lang.today')</td>
                                <td class="p-2"><code>{todays_date}</code></td>
                            </tr>
                            @if(isset($customfields) && $customfields->count() > 0 && $document->docresource_type == 'client')
                            <tr>
                                <td colspan="2" class="bg-light font-weight-bold p-2">@lang('lang.custom_fields')</td>
                            </tr>
                            @foreach($customfields as $field)
                            <tr>
                                <td class="p-2">{{ $field->customfields_title }}</td>
                                <td class="p-2"><code>{<span>{{ $field->customfields_name }}</span>}</code></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->