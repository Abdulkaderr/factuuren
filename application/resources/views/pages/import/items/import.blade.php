@extends('pages.import.wrapper')
<!--SECOND STEP FORM-->
@section('second-step-form')
<div class="form-group form-group-checkbox row">
    <div class="col-12 p-t-5">
        <div class="text-center">
            <input type="checkbox" id="skip_duplicates" name="skip_duplicates" class="filled-in chk-col-light-blue"
                checked>
            <label class="p-l-30" for="skip_duplicates">@lang('lang.skip_duplicate_items')</label>
        </div>
    </div>
</div>
@endsection