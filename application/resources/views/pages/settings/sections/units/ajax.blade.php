@foreach($units as $unit)
<!--each row-->
<tr id="unit_{{ $unit->unit_id }}">
    <td class="units_col_name">
        {{ $unit->unit_name }}
    </td>
    <td class="units_col_created_by">
        <img src="{{ getUsersAvatar($unit->avatar_directory, $unit->avatar_filename, $unit->unit_creatorid) }}" alt="user"
            class="img-circle avatar-xsmall">
            {{ checkUsersName($unit->first_name, $unit->unit_creatorid)  }}
        </td>
    <td class="units_col_products">
        <span class="badge badge-light">{{ $unit->count_items ?? 0 }}</span>
    </td>
    <td class="units_col_action actions_column">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit" >
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-tooltip data-toggle-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal" title="{{ cleanLang(__('lang.edit')) }}"
                data-url="{{ url('/settings/units/'.$unit->unit_id.'/edit') }}"
                data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_unit')) }}"
                data-action-url="{{ url('/settings/units/'.$unit->unit_id) }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="units-td-container">
                <i class="sl-icon-note"></i>
            </button>
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}" class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_unit')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                data-ajax-type="DELETE" data-url="{{ url('/') }}/settings/units/{{ $unit->unit_id }}">
                <i class="sl-icon-trash"></i>
            </button>
        </span>
        <!--action button-->
    </td>
</tr>
@endforeach
<!--each row-->