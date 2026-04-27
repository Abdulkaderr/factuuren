<div class="row">
    <div class="col-lg-12">
        <div class="p-b-10 text-right">
            @if($note->permission_edit_delete_note)
            <!-- quick edit button - loads the edit form into the same modal -->
            <button type="button"
                class="btn btn-xxs btn-outline-info waves-effect text-left edit-add-modal-button ajax-request m-r-5"
                data-url="{{ url('notes/'.$note->note_id.'/edit') }}"
                data-skip-modal-body-reset="yes"
                data-modal-title="@lang('lang.edit_note')"
                data-action-url="{{ url('notes/'.$note->note_id.'?ref=show-modal') }}"
                data-action-method="PUT">@lang('lang.edit_note')</button>
            @endif
        </div>
        <div class="p-b-30">{!! clean($note->note_description) ?? '---' !!}</div>
    </div>
    <div class="col-lg-12">
        <div class="p-t-30">
            <h6>@lang('lang.attachments')</h6>
            <table class="table table-bordered">
                <tbody>
                    @foreach($attachments as $attachment)
                    <tr id="note_attachment_{{ $attachment->attachment_id }}">
                        <td><a href="notes/attachments/download/{{ $attachment->attachment_uniqiueid }}" download>
                                {{ $attachment->attachment_filename }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>