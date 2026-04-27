<div class="row">
    <div class="col-lg-12">
        <!--unit name-->
        <div class="form-group row">
            <label class="col-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.unit_name')) }}*</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="unit_name" name="unit_name"
                    placeholder="{{ cleanLang(__('lang.units_examples')) }}"
                    value="{{ $unit->unit_name ?? '' }}">
            </div>
        </div>
    </div>
</div>
