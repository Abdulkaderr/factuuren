@foreach($refunds as $refund)
<!--each row-->
<tr id="refund_{{ $refund->refund_id }}">

    <!--checkbox-->
    @if(config('visibility.refunds_col_checkboxes'))
    <td class="refunds_col_checkbox checkitem" id="refunds_col_checkbox_{{ $refund->refund_id }}">
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-refunds-{{ $refund->refund_id }}"
                name="ids[{{ $refund->refund_id }}]"
                class="listcheckbox listcheckbox-refunds filled-in chk-col-light-blue"
                data-actions-container-class="refunds-checkbox-actions-container">
            <label for="listcheckbox-refunds-{{ $refund->refund_id }}"></label>
        </span>
    </td>
    @endif

    <!--refund id-->
    <td class="refunds_col_id" id="refunds_col_id_{{ $refund->refund_id }}">
        <a href="javascript:void(0)" class="show-modal-button js-ajax-ux-request" data-toggle="modal"
            data-url="{{ url('refunds/'.$refund->refund_uniqueid) }}" data-target="#plainModal"
            data-loading-target="plainModalBody" data-modal-title="@lang('lang.refund_details')">
            {{ runtimeRefundIdFormat($refund->refund_id) }}
        </a>
    </td>

    <!--refund date-->
    <td class="refunds_col_date" id="refunds_col_date_{{ $refund->refund_id }}">
        {{ runtimeDate($refund->refund_date) }}
    </td>

    <!--linked payment id-->
    <td class="refunds_col_payment" id="refunds_col_payment_{{ $refund->refund_id }}">
        <a href="javascript:void(0)" class="show-modal-button js-ajax-ux-request" data-toggle="modal"
            data-url="{{ url('/') }}/payments/{{ $refund->refund_paymentid }}" data-target="#plainModal"
            data-loading-target="plainModalBody" data-modal-title="">
            {{ runtimeRefundIdFormat($refund->refund_paymentid) }}
        </a>
    </td>

    <!--amount-->
    <td class="refunds_col_amount" id="refunds_col_amount_{{ $refund->refund_id }}">
        {{ runtimeMoneyFormat($refund->refund_amount) }}
    </td>

    <!--client-->
    <td class="refunds_col_client" id="refunds_col_client_{{ $refund->refund_id }}">
        <a href="/clients/{{ $refund->refund_clientid }}">{{ $refund->client_company_name ?? '---' }}</a>
    </td>

    <!--issued by-->
    <td class="refunds_col_creator" id="refunds_col_creator_{{ $refund->refund_id }}">
        <span class="printing_hidden">
            <img src="{{ getUsersAvatar($refund->creator_avatar_directory, $refund->creator_avatar_filename, $refund->refund_creatorid) }}"
                alt="user" class="img-circle avatar-xsmall printing_hidden">
            <span class="user-profile-first-name">{{ checkUsersName($refund->first_name, $refund->refund_creatorid) }}</span>
        </span>
        <span class="hidden printing_visible">
            {{ $refund->first_name ?? runtimeUnkownUser() }} {{ $refund->last_name ?? '' }}
        </span>
    </td>

    <!--tags-->
    @if(config('visibility.refunds_col_tags'))
    <td class="refunds_col_tags" id="refunds_col_tags_{{ $refund->refund_id }}">
        <!--tag-->
        @if(count($refund->tags ?? []) > 0)
        <span class="label label-outline-default">{{ str_limit($refund->tags->first()->tag_title, 15) }}</span>
        @else
        <span>---</span>
        @endif
        <!--/#tag-->

        <!--more tags-->
        @if(count($refund->tags ?? []) > 1)
        @php $tags = $refund->tags; @endphp
        @include('misc.more-tags')
        @endif
        <!--more tags-->
    </td>
    @endif
    <!--tags-->

    <!--action buttons-->
    @if(config('visibility.refunds_col_action'))
    <td class="refunds_col_action actions_column" id="refunds_col_action_{{ $refund->refund_id }}">
        <span class="list-table-action font-size-inherit">

            <!--view receipt-->
            <a href="javascript:void(0)" title="@lang('lang.view')"
                class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm show-modal-button js-ajax-ux-request"
                data-toggle="modal"
                data-url="{{ url('refunds/'.$refund->refund_uniqueid) }}"
                data-target="#plainModal"
                data-loading-target="plainModalBody"
                data-modal-title="@lang('lang.refund_details')">
                <i class="ti-new-window"></i>
            </a>

            <!--edit-->
            @if(config('visibility.action_buttons_edit'))
            <button type="button" title="@lang('lang.edit')"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal"
                data-target="#commonModal"
                data-url="{{ urlResource('/refunds/'.$refund->refund_uniqueid.'/edit') }}"
                data-loading-target="commonModalBody"
                data-modal-title="@lang('lang.edit_refund')"
                data-action-url="{{ urlResource('/refunds/'.$refund->refund_uniqueid) }}"
                data-action-method="PUT"
                data-action-ajax-class="js-ajax-ux-request"
                data-action-ajax-loading-target="refunds-td-container">
                <i class="sl-icon-note"></i>
            </button>
            @endif

            <!--delete-->
            @if(config('visibility.action_buttons_delete'))
            <button type="button" title="@lang('lang.delete')"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="@lang('lang.delete_refund')"
                data-confirm-text="@lang('lang.are_you_sure')"
                data-ajax-type="DELETE"
                data-url="{{ url('/refunds/'.$refund->refund_id) }}">
                <i class="sl-icon-trash"></i>
            </button>
            @endif

            <!--more dropdown-->
            @if(auth()->user()->is_team)
            <span class="list-table-action dropdown font-size-inherit">
                <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" title="{{ cleanLang(__('lang.more')) }}"
                    class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm">
                    <i class="ti-more"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="listTableAction">
                    <!--edit tags-->
                    <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form edit-add-modal-button"
                        href="javascript:void(0)" data-toggle="modal" data-target="#commonModal"
                        data-url="{{ url('/refunds/'.$refund->refund_id.'/edit-tags') }}"
                        data-loading-target="commonModalBody" data-modal-title="@lang('lang.edit_tags')"
                        data-action-url="{{ url('/refunds/'.$refund->refund_id.'/edit-tags') }}"
                        data-action-method="POST" data-action-ajax-class="ajax-request"
                        data-action-ajax-loading-target="refunds-td-container">
                        @lang('lang.edit_tags')
                    </a>
                </div>
            </span>
            @endif

        </span>
    </td>
    @endif

</tr>
<!--each row-->
@endforeach
