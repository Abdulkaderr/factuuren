<div id="add-query-form">

    <div class="form-group row">
        <label class="col-sm-12 text-left control-label col-form-label required">
            @lang('lang.description')
        </label>
        <div class="col-sm-12">
            <input type="text"
                   class="form-control form-control-sm"
                   id="execute_query_description"
                   name="execute_query_description">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-12 text-left control-label col-form-label required">
            @lang('lang.sql_query')
        </label>
        <div class="col-sm-12">
            <textarea class="form-control form-control-sm"
                      id="execute_query_sql"
                      name="execute_query_sql"
                      rows="15"></textarea>
        </div>
    </div>
</div>
