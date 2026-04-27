"use strict";

/** --------------------------------------------------------------------------------------------------
 *  MAIN MENU - TOGGLE ATIVE MENU
 * - @updated July 2025
 * - @notes
 * - Its now easy to set which menu is triggered open when a page loads
 * - This opens the main menu, based on values set in the controller pageSettings()
 *      - $page['main_menu_id']
 *      - $page['sub_menu_id']
 * - These attributes are then set in the global blade view:
 *      - /resources/views/layout/wrapper.blade.php
 * --------------------------------------------------------------------------------------------------*/
window.addEventListener('load', function () {
    var main_menu_id = $("#main-body").attr('data-main-menu-id');
    var sub_menu_id = $("#main-body").attr('data-sub-menu-id');
    //activate main menu
    if (main_menu_id) {
        var main_menu_element = $("#" + main_menu_id);
        if (main_menu_element.length) {
            main_menu_element.trigger('click');
        }
    }
    //activate sub menu
    if (sub_menu_id) {
        var sub_menu_element = $("#" + sub_menu_id);
        if (sub_menu_element.length) {
            sub_menu_element.addClass('active');
        }
    }
});


$(document).ready(function () {


    /** --------------------------------------------------------------------------------------------------
     *  [subscription product - price] - on selecting product, update the price for that product
     *  [notes]
     * --------------------------------------------------------------------------------------------------*/
    //client list has been reset or cleared
    $(document).on("select2:unselecting", ".stripe_product_price", function (e) {
        NX.clientAndProjectsClearToggle($(this));
    });
    //client list has been reset or cleared
    $(document).on("select2:select", ".stripe_product_price", function (e) {
        NX.stripeProductPriceToggle(e, $(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [link on a div]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".click-url, .url-link", function (e) {
        window.location = $(this).attr("data-url");
    });

    /** --------------------------------------------------------------------------------------------------
     *  [remove preloader]
     * -------------------------------------------------------------------------------------------------*/
    $(".preloader").fadeOut('slow', function () {
        NProgress.done();
    });


    /** --------------------------------------------------------------------------------------------------
     *  prevent events from bubbling down
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-stop-propagation", function (event) {
        event.stopPropagation();
    });


    /** --------------------------------------------------------------------------------------------------
     *  [side filter panel] - toggle
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-side-panel", function () {
        NX.toggleSidePanel($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [side panel with ajax] - toggle
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-side-panel-ajax", function () {
        NX.toggleSidePanelAjax($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [stats widget] - toggle
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-stats-widget", function () {
        NX.toggleListPagesStatsWidget($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [add user modal] - toggle client options
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-client-options", function () {
        NX.toggleAddUserClientOptions($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [select2 single select with tagging] - custom initialization for single-select dropdowns that
     *  allow free-typing new options (tags) without enabling multi-select
     * -------------------------------------------------------------------------------------------------*/
    $(".select2-single-tags").select2({
        theme: "bootstrap",
        width: null,
        containerCssClass: ':all:',
        tags: true,
    });

    /** --------------------------------------------------------------------------------------------------
     *  [add item modal button] - reset target form
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".reset-target-modal-form", function () {
        NX.resetTargetModalForm($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [reset filter panel] - resets the form fields
     * ---------------------------------------------------------*/
    $(document).on("click", ".js-reset-filter-side-panel", function () {
        NX.resetFilterPanelFields($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [filter panel] - preselect saved filter values for select2 ajax fields
     *  This handles fields with data-filter-preselect-id and data-filter-preselect-text attributes
     * -------------------------------------------------------------------------------------------------*/
    function preselectFilterSelect2Ajax() {
        $('.js-select2-basic-search, .js-select2-basic-search-modal, .js-select2-dynamic-project').each(function() {
            var $select = $(this);
            var preselectId = $select.attr('data-filter-preselect-id');
            var preselectText = $select.attr('data-filter-preselect-text');

            if (preselectId && preselectText) {
                // Create a new option and append it to the select
                var newOption = new Option(preselectText, preselectId, true, true);
                $select.append(newOption);

                // Trigger change to notify Select2 and update the display
                $select.trigger('change');
            }
        });
    }

    // Call preselection when filter panel is opened
    $(document).on("click", ".js-toggle-side-panel", function () {
        var targetPanel = $(this).attr('data-target');
        // Check if this is a filter panel
        if (targetPanel && targetPanel.includes('filter')) {
            // Small delay to ensure panel is visible and Select2 is initialized
            setTimeout(function() {
                preselectFilterSelect2Ajax();
            }, 100);
        }
    });

    /** --------------------------------------------------------------------------------------------------
     *  [add clients modal] - toggle address section
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-switch-toggle-hidden-content", function () {
        NX.switchToggleHiddenContent($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [various] - toggle form options
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-form-options", function () {
        NX.toggleFormOptions($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [pushstate] - change url in address bar
     * -------------------------------------------------------------------------------------------------*/
    $(".project-top-nav").on("click", 'a', function () {
        NX.expandTabbedPage($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [add-edit-project] - add or edit project button clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.add-edit-project-button', function () {
        NX.addEditProjectButton($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [update user preference] - e.g. leftmenu, stats
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.update-user-ux-preferences', function () {
        NX.updateUserUXPreferences($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [apply filter button] - button clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.apply-filter-button', function () {
        NX.applyFilterButton($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [lists main checkbox] - checkbox clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("change", '.listcheckbox-all', function () {
        NX.listCheckboxAll($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [lists main checkbox] - checkbox clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("change", '.listcheckbox', function () {
        NX.listCheckbox($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [clients & projects] - on selecting clients, update the projects dropdown to show clients projects
     *  [notes]
     *       - the clients dropdown must have the following
     *       - class="clients_and_projects_toggle"
     *       - data-projects-dropdown="id-of-the-projects-dropdown"
     *       - data-feed-request-type="filter_tickets" (as checked in feed controller)
     * --------------------------------------------------------------------------------------------------*/
    //client list has been reset or cleared
    $(document).on("select2:unselecting", ".clients_and_projects_toggle", function (e) {
        NX.clientAndProjectsClearToggle($(this));
    });
    //client list has been reset or cleared
    $(document).on("select2:select", ".clients_and_projects_toggle", function (e) {
        NX.clientAndProjectsToggle(e, $(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [project & users] - on selecting project, update users dropdown to show assigned users
     *  [notes]
     *       - the projects dropdown must have the following
     *       - class="projects_assigned_toggle"
     *       - data-assigned-dropdown="id-of-the-users-dropdown"
     * --------------------------------------------------------------------------------------------------*/
    //client list has been reset or cleared
    $(document).on("select2:unselecting", ".projects_assigned_toggle", function (e) {
        NX.projectsAndAssignedClearToggle($(this));
    });
    //client list has been reset or cleared
    $(document).on("select2:select", ".projects_assigned_toggle", function (e) {
        NX.projectAndAssignedCToggle(e, $(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [project & users] - on selecting project, update tasks dropdown to show  tasks
     *  [notes]
     *       - the projects dropdown must have the following
     *       - class="projects_my_tasks_toggle"
     *       - data-task-dropdown="id-of-the-task-dropdown"
     * --------------------------------------------------------------------------------------------------*/
    //project list has been reset or cleared
    $(document).on("select2:unselecting", ".projects_my_tasks_toggle", function (e) {
        //toggle task drop down
        NX.projectsTasksClearToggle($(this));

        // Get row ID from the project dropdown ID
        var $projectDropdown = $(this);
        var projectSelectId = $projectDropdown.attr('id');
        var rowId = projectSelectId.replace('my_assigned_projects_', '');

        // Disable and clear date/time fields for this row
        $("#manual_timer_created_" + rowId).prop('disabled', true).val('');
        $("#timer_created_edit_" + rowId).prop('disabled', true).val('');
        $("#manual_time_hours_" + rowId).prop('disabled', true).val('');
        $("#manual_time_minutes_" + rowId).prop('disabled', true).val('');
    });
    //projecct list - a project has been selected
    $(document).on("select2:select", ".projects_my_tasks_toggle", function (e) {
        //populate the tasks dropdown
        NX.projectAssignedTasksToggle(e, $(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [toggle ticket editor or view mode]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.ticket-editor-toggle', function () {
        NX.ticketEditorToggle($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [default category icon] clicked - show alert
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-system-default-category", function () {
        $.confirm({
            theme: 'modern',
            type: 'blue',
            title: NXLANG.default_category,
            content: NXLANG.system_default_category_cannot_be_deleted,
            buttons: {
                cancel: {
                    text: NXLANG.close,
                    btnClass: ' btn-sm btn-outline-info',
                },
            },
        });
    });

    /** --------------------------------------------------------------------------------------------------
     *  [toggle ticket editor or view mode]
     * -------------------------------------------------------------------------------------------------*/
    $(document).ready(function () {
        $(document).on({
            mouseenter: function () {
                $(this).find('.js-hover-actions-target').show();
            },
            mouseleave: function () {
                $(this).find('.js-hover-actions-target').hide();
            }
        }, ".js-hover-actions");
    });



    /** --------------------------------------------------------------------------------------------------
     *  [general placeholder clicked]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.js-toggle-placeholder-element', function () {
        NX.togglePlaceHolders($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [general close button clicked]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.js-toggle-close-button', function () {
        NX.toggleCloseButtonElements($(this));
    });


    /** ----------------------------------------------------------
     *  [jquery.confirm] [option 1]
     *     - form fields in confirm dialogue (such as check boxes)
     * -----------------------------------------------------------*/
    //set the form value to the actual form value
    $(document).on('change', '.confirm_action_checkbox', function () {
        //hidden field
        var hidden_field = $("#" + $(this).attr('data-field-id'));
        if ($(this).is(':checked')) {
            hidden_field.val('on')
        } else {
            hidden_field.val('')
        }
    });


    /** ----------------------------------------------------------
     *  [jquery.confirm] [option 2]
     * -----------------------------------------------------------*/
    //set the form value to the actual form value
    $(document).on('change', '.confirm_popup_checkbox', function () {
        //hidden field
        var hidden_field = $("#" + $(this).attr('data-confirm-checkbox-field-id'));
        if ($(this).is(':checked')) {
            hidden_field.val('on')
        } else {
            hidden_field.val('')
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  [add timesheet row] - add new timesheet entry row
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", "#add_timesheet_row", function (e) {
        e.preventDefault();

        // Generate unique ID
        var unique_id = 'row_' + Math.random().toString(36).substr(2, 9);

        // Clone the default row
        var $default_row = $("#timesheet_row_default");

        // Save current selected values before destroying
        var saved_values = {};
        $default_row.find('select.select2-hidden-accessible').each(function() {
            var $select = $(this);
            saved_values[$select.attr('id')] = {
                value: $select.val(),
                text: $select.find('option:selected').text()
            };
        });

        // Destroy Select2 instances before cloning to prevent duplication
        $default_row.find('select.select2-hidden-accessible').each(function() {
            if ($(this).data('select2')) {
                $(this).select2('destroy');
            }
        });

        // Destroy datepicker instances before cloning
        $default_row.find('.pickadate').each(function() {
            var $input = $(this);
            if ($input.data('datepicker')) {
                $input.datepicker('destroy');
            }
        });

        var $new_row = $default_row.clone();

        // Re-initialize Select2 on default row
        $default_row.find('.select2-basic').select2();
        $default_row.find('.select2-preselected').each(function() {
            var $select = $(this);
            var select_id = $select.attr('id');

            // Restore saved value if exists, otherwise use preselected
            if (saved_values[select_id] && saved_values[select_id].value) {
                $select.val(saved_values[select_id].value).trigger('change');
            } else {
                var preselected = $select.data('preselected');
                if (preselected) {
                    $select.val(preselected).trigger('change');
                }
            }
        });
        $default_row.find('.js-select2-basic-search-modal').select2({
            theme: "bootstrap",
            width: null,
            containerCssClass: ':all:',
            minimumInputLength: 1,
            minimumResultsForSearch: 1,
            ajax: {
                dataType: "json",
                type: "GET",
                data: function (params) {
                    var queryParameters = {
                        term: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.value,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        // Restore saved values for AJAX-based select2 dropdowns
        $default_row.find('.js-select2-basic-search-modal, .projects_my_tasks_toggle').each(function() {
            var $select = $(this);
            var select_id = $select.attr('id');

            if (saved_values[select_id] && saved_values[select_id].value) {
                // Add the option to the select
                var option = new Option(saved_values[select_id].text, saved_values[select_id].value, true, true);
                $select.append(option).trigger('change');
            }
        });

        // Re-initialize datepicker on default row
        $default_row.find('.pickadate').datepicker({
            format: NX.date_picker_format,
            language: "lang",
            autoclose: true,
            class: "datepicker-default",
            todayHighlight: true
        });

        // Update row ID and data attribute
        $new_row.attr('id', 'timesheet_row_' + unique_id);
        $new_row.attr('data-row-id', unique_id);

        // Replace all name attributes with new unique ID
        $new_row.find('input, select').each(function() {
            var name = $(this).attr('name');
            if (name) {
                // Replace both [default] and _default patterns in names
                var new_name = name.replace('[default]', '[' + unique_id + ']').replace('_default', '_' + unique_id);
                $(this).attr('name', new_name);
            }

            var id = $(this).attr('id');
            if (id) {
                var new_id = id.replace('_default', '_' + unique_id);
                $(this).attr('id', new_id);
            }
        });

        // Update data-task-dropdown attribute
        $new_row.find('.projects_my_tasks_toggle').attr('data-task-dropdown', 'my_assigned_tasks_' + unique_id);

        // Update data-ajax--url for project dropdown
        var user_id = $new_row.find('.projects_my_tasks_toggle').data('user-id');
        if (user_id) {
            $new_row.find('.projects_my_tasks_toggle').attr('data-ajax--url', '/feed/users-projects?user_id=' + user_id);
        }

        // Clear values
        $new_row.find('input[type="text"], input[type="number"], input[type="hidden"]:not([name*="timesheet_user"])').val('');
        $new_row.find('select:not([name*="timesheet_user"])').val(null);

        // Disable Date, Hrs, Mins fields in new row (must be enabled only after task selection)
        $new_row.find('input[id^="manual_timer_created_"]').prop('disabled', true);
        $new_row.find('input[id^="timer_created_edit_"]').prop('disabled', true);
        $new_row.find('input[id^="manual_time_hours_"]').prop('disabled', true);
        $new_row.find('input[id^="manual_time_minutes_"]').prop('disabled', true);

        // Get language string from data attribute
        var lang_remove = $('#timesheet_rows_container').data('lang-remove') || 'Remove';

        // Add delete button
        var delete_btn = '<div class="form-group row m-t-15"><div class="col-12 text-right">' +
            '<button type="button" class="btn btn-sm btn-danger remove-timesheet-row" data-row-id="' + unique_id + '">' +
            '<i class="ti-close"></i> ' + lang_remove + '</button></div></div>';
        $new_row.append(delete_btn);

        // Append to container
        $("#timesheet_rows_container").append($new_row);

        // Re-initialize Select2 for new row
        $new_row.find('.select2-basic').select2();
        $new_row.find('.select2-preselected').each(function() {
            var preselected = $(this).data('preselected');
            if (preselected) {
                $(this).val(preselected).trigger('change');
            }
        });
        $new_row.find('.js-select2-basic-search-modal').select2({
            theme: "bootstrap",
            width: null,
            containerCssClass: ':all:',
            minimumInputLength: 1,
            minimumResultsForSearch: 1,
            ajax: {
                dataType: "json",
                type: "GET",
                data: function (params) {
                    var queryParameters = {
                        term: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.value,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        // Initialize datepicker on new row
        $new_row.find('.pickadate').datepicker({
            format: NX.date_picker_format,
            language: "lang",
            autoclose: true,
            class: "datepicker-default",
            todayHighlight: true
        });
    });


    /** --------------------------------------------------------------------------------------------------
     *  [remove timesheet row] - remove a timesheet entry row
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".remove-timesheet-row", function (e) {
        e.preventDefault();
        var row_id = $(this).data('row-id');

        // Don't allow removing the default row
        if (row_id !== 'default') {
            $("#timesheet_row_" + row_id).remove();
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  [timesheet date picker] - update hidden field when date is selected
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("changeDate", ".pickadate", function (e) {
        var mysql_date = moment(e.date).format('YYYY-MM-DD');
        var name = $(this).attr('name');
        $("#" + name).val(mysql_date);
    });

    $(document).on("change", ".pickadate", function (e) {
        var name = $(this).attr('name');
        //reset for empty fields
        if ($(this).val() == '') {
            $("#" + name).val('');
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  [timesheet task selected] - enable date and time fields when task is selected
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "select[id^='my_assigned_tasks_']", function (e) {
        var $select = $(this);
        var selectId = $select.attr('id');
        var rowId = selectId.replace('my_assigned_tasks_', '');

        // Enable the date, hours, and minutes fields for this row
        $("#manual_timer_created_" + rowId).prop('disabled', false);
        $("#timer_created_edit_" + rowId).prop('disabled', false);
        $("#manual_time_hours_" + rowId).prop('disabled', false);
        $("#manual_time_minutes_" + rowId).prop('disabled', false);
    });


    /** --------------------------------------------------------------------------------------------------
     *  [timesheet task cleared] - disable and reset date and time fields when task is cleared
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:unselecting", "select[id^='my_assigned_tasks_']", function (e) {
        var $select = $(this);
        var selectId = $select.attr('id');
        var rowId = selectId.replace('my_assigned_tasks_', '');

        // Disable the date, hours, and minutes fields for this row
        $("#manual_timer_created_" + rowId).prop('disabled', true);
        $("#timer_created_edit_" + rowId).prop('disabled', true);
        $("#manual_time_hours_" + rowId).prop('disabled', true);
        $("#manual_time_minutes_" + rowId).prop('disabled', true);

        // Clear the values
        $("#manual_timer_created_" + rowId).val('');
        $("#timer_created_edit_" + rowId).val('');
        $("#manual_time_hours_" + rowId).val('');
        $("#manual_time_minutes_" + rowId).val('');
    });


    /** --------------------------------------------------------------------------------------------------
     *  [task - checklist text clicked]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.js-card-checklist-toggle', function (e) {
        e.preventDefault();
        //toggle
        NX.toggleEditTaskChecklist($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [task - reset the task form]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.reset-card-modal-form', function (e) {
        NX.resetCardModal($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [task - checklist text clicked]
     * -------------------------------------------------------------------------------------------------*/
    $(document).ready(function () {
        $(document).on({
            mouseenter: function () {
                //hide all
                $('.checklist-action-buttons').hide();
                $(this).find('.checklist-action-buttons').show();
            },
            mouseleave: function () {
                $('.checklist-action-buttons').hide();
            }
        }, ".checklist-item");
    });


    /** --------------------------------------------------------------------------------------------------
     *  [better ux on delete items] - remove item from list whilst the ajax happend in background
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.js-delete-ux', function () {
        NX.uxDeleteItem($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [toggle task timer buttons]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.js-timer-button', function (e) {
        NX.toggleTaskTimer($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [toggle settings left menu]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.js-toggle-settings-menu', function (e) {
        NX.toggleSettingsLeftMenu($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [convert lead to a customer]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", '.js-lead-convert-to-customer', function (e) {
        //add overlay
        $("#leadConvertToCustomer").addClass('overlay');
        nxAjaxUxRequest($(this));
        NX.convertLeadForm($(this), 'show');
    });
    $(document).on("click", '.js-lead-convert-to-customer-close', function (e) {
        NX.convertLeadForm($(this), 'hide');
    });


    /** --------------------------------------------------------------------------------------------------
     *  [top nav events - show]
     * -------------------------------------------------------------------------------------------------*/
    $("#topnav-notification-dropdown").on("show.bs.dropdown", function (e) {
        NX.eventsTopNav($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [top nav events - mark all events as read]
     * -------------------------------------------------------------------------------------------------*/
    $("#topnav-notification-mark-all-read").on('click', function (e) {
        NX.eventsTopNavMarkAllRead($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [top nav events - mark one event as read]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.js-notification-mark-read-single', function (e) {
        NX.eventsMarkRead($(this), 'single');
    });

    /** --------------------------------------------------------------------------------------------------
     *  [app][change dynamic urls]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.js-dynamic-url', function (e) {
        NX.browserPushState($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [settings][change dynamic urls]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.js-dynamic-settings-url', function (e) {
        //set the dynamic url
        var self = $(this);
        var url = self.attr('data-url');
        var dynamic_url = 'app' + url;
        self.attr('data-dynamic-url', dynamic_url);
        //update browser address bar
        NX.browserPushState($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [settings][email template selected]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('change', '#selectEmailTemplate', function (e) {
        NX.loadEmailTemplate($(this));
    });



    /** --------------------------------------------------------------------------------------------------
     *  [settings][clear cache]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#clearSystemCache', function (e) {
        NX.clearSystemCache($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [settings][clear cache]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.toggle-invoice-tax', function (e) {
        NX.toggleInvoiceTaxEditing($(this));
    });


    /** ------------------------------------------------------------------------------
     *  - close any other static popover windows
     * ------------------------------------------------------------------------------- */
    $(document).on('click', '.js-elements-popover-button', function () {
        $('.js-elements-popover-button').not(this).popover('hide');
    });

    /** ---------------------------------------------------
     *  Show a popover with dynamic html content
     *  - html content is set in a hidden div
     *  - button has id of hidden div
     *  <button class="btn btn-info btn-sm js-dynamic-popover-button" tabindex="0" 
     *          data-popover-content="--html entities endoced (php) html here---"
     *          data-placement="top"
     *          data-title="Taxes Rates~"> Tax Rates~ </button>
     * -------------------------------------------------- */
    $(document).find(".js-elements-popover-button").each(function () {
        $(this).popover({
            html: true,
            sanitize: false, //The HTML is NOT user generated
            template: NX.basic_popover_template,
            title: $(this).data('title'),
            content: function () {
                //popover elemenet
                var str = $(this).attr('data-popover-content');
                //decode html entities
                return $("<div/>").html(str).text();
            }
        });
    });

    /** --------------------------------------------------------------------------------------------------
     *  [pay now] payment opion selected
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#invoice-make-payment-button', function (e) {
        $("#invoice-buttons-container").hide();
        $("#invoice-pay-container").show();
    });



    /** --------------------------------------------------------------------------------------------------
     *  [payn ow] cancel payment button clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#invoice-cancel-payment-button', function (e) {
        $("#invoice-pay-container").hide();
        $(".payment-gateways").hide();
        $("#invoice-buttons-container").show();
    });


    /** --------------------------------------------------------------------------------------------------
     *  [pay now] payment opion selected
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.invoice-pay-gateway-selector', function (e) {
        NX.selectPaymentGateway($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [disable button on click]
     *  disable the button on click
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.disable-on-click', function (e) {
        $(this).prop("disabled", true);
        $(this).addClass('button-loading-annimation');
    });

    /** --------------------------------------------------------------------------------------------------
     *  [disable button on click]
     *  disable a button on click and add the loading annimation. Good for Stripe and Payal buttons etc
     *  [IMPORTANT] do not use this class on ajax buttons. They have their own data-property for this
     *              using this will prevent ajax form submitting
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.disable-on-click-loading', function (e) {

        $(this).prop("disabled", true); //this is stopping form submits
        $(this).addClass('button-loading-annimation');
    });


    /** --------------------------------------------------------------------------------------------------
     *  [disable button on click]
     *  disable a button, change to please wait, add loading annimation
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.disable-on-click-please-wait', function (e) {
        $(this).html('&nbsp;&nbsp;&nbsp;' + NXLANG.please_wait + '...&nbsp;&nbsp;&nbsp;');
        $(this).prop("disabled", true); //this is stopping form submits
        $(this).addClass('button-loading-annimation');
    });



    /** --------------------------------------------------------------------------------------------------
     *  [shipping address] same as billing address
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", "#same_as_billing_address", function () {
        NX.shippingAddressSameBilling($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [toggle menu clicked] - update the autoscroll bar
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".main-hamburger-menu", function () {
        if (typeof navleft != 'undefined') {
            navLeftScroll.update();
        }
        //reset menu tooltips
        NXleftMenuToolTips();
    });
    $(document).on("click", ".settings-hamburger-menu", function () {
        if (typeof navleft != 'undefined') {
            navLeftScroll.update();
        }
    });




    /** --------------------------------------------------------------------------------------------------
     *  [select2] clear validation.js errors (if any) on selecting drop down
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('select2:select', '.select2-hidden-accessible', function () {
        try {
            if ($(this).valid()) {
                $(this).next('span').removeClass('error').addClass('valid');
            }
        } catch (err) {
            //we are expecting this error for none validated select2 elements. nothing to do here.
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  toggle target element
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".toggle-collapse", function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        if (target != '') {
            $(target).toggle();
        }
    });



    /*----------------------------------------------------------------
     *  [tax button clicked] - set popover dom
     *---------------------------------------------------------------*/
    $(document).on('click', '#billing-tax-popover-button', function (e) {
        //is the tax button enabled?
        if ($(this).hasClass('disabled')) {
            $(this).popover('hide');
            //error message
            NX.notification({
                type: 'error',
                message: NXLANG.add_lineitem_items_first
            });
            NXINVOICE.log('[invoicing] initialiseTaxPopover() - tax button is disabled');
        } else {
            NXINVOICE.toggleTaxDom($("#bill_tax_type").val());
        }
    });

    /*----------------------------------------------------------------
     *  [tax type] - tax type drop down has been changed
     *---------------------------------------------------------------*/
    $(document).on('change', '#billing-tax-type', function () {
        NXINVOICE.toggleTaxDom($(this).val());
    });


    /*----------------------------------------------------------------
     *  [tax popover - submit button] - clicked
     *---------------------------------------------------------------*/
    $(document).on('click', '#billing-tax-popover-update', function (e) {
        //update tax type
        NXINVOICE.updateTax();
    });



    /*----------------------------------------------------------------
     *  [adjustments button clicked] - set popover dom
     *---------------------------------------------------------------*/
    $(document).on('click', '#billing-adjustment-popover-button', function () {
        NXINVOICE.toggleAdjustmentDom();
    });

    /*----------------------------------------------------------------
     *  [adjustments popover - submit button] - clicked
     *---------------------------------------------------------------*/
    $(document).on('click', '#billing-adjustment-popover-update', function (e) {
        //update tax type
        NXINVOICE.updateAdjustment();
    });

    /*----------------------------------------------------------------
     *  [adjustments popover - remove button] - clicked
     *---------------------------------------------------------------*/
    $(document).on('click', '#billing-adjustment-popover-remove', function (e) {
        //update tax type
        NXINVOICE.removeAdjustment();
    });


    /*----------------------------------------------------------------
     *  [discount button clicked] - set popover dom
     *---------------------------------------------------------------*/
    $(document).on('click', '#billing-discounts-popover-button', function () {
        //is the discounts button enabled?
        if ($(this).hasClass('disabled')) {
            $(this).popover('hide');
            //error message
            NX.notification({
                type: 'error',
                message: NXLANG.add_lineitem_items_first
            });
        } else {
            NXINVOICE.toggleDiscountDom($("#bill_discount_type").val());
        }
    });


    /*----------------------------------------------------------------
     *  [discount type] - tax type drop down has been changed
     * ------------------------------------------------------------*/
    $(document).on('change', '#js-billing-discount-type', function () {
        NXINVOICE.toggleDiscountDom($(this).val());
    });


    /*----------------------------------------------------------------
     *  [discount popover - submit button] - clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '#billing-discount-popover-update', function (e) {
        //update tax type
        NXINVOICE.updateDiscount();
    });


    /*----------------------------------------------------------------
     *  [line item] - add new blank line button has been clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '#billing-item-actions-blank', function (e) {
        NXINVOICE.DOM.itemNewLine();
    });


    /*----------------------------------------------------------------
     *  [line item] - add new blank line button has been clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '#billing-time-actions-blank', function (e) {
        NXINVOICE.DOM.timeNewLine();
    });

    /*----------------------------------------------------------------
     *  [line item] - add new blank line button has been clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '#billing-dimensions-actions-blank', function (e) {
        NXINVOICE.DOM.dimensionsNewLine();
    });


    /*----------------------------------------------------------------
     *  [line item] - delete line button has been clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '.js-billing-line-item-delete', function (e) {
        NXINVOICE.DOM.deleteLine($(this));
    });


    /*----------------------------------------------------------------
     *  [bill item] - add selected bill items button clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '#itemsModalSelectButton, #categoryItemsModalSelectButton', function (e) {
        NXINVOICE.DOM.addSelectedProductItems($(this));
    });


    /*----------------------------------------------------------------
     *  [epxense item] - add selected expenses button clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '#expensesModalSelectButton', function (e) {
        NXINVOICE.DOM.addSelectedExpense($(this));
    });


    /*----------------------------------------------------------------
     * [task item] - add selected tasks button clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '#tasksModalSelectButton', function (e) {
        NXINVOICE.DOM.addSelectedTask($(this));
    });


    /*----------------------------------------------------------------
     *  [time item] - add time billing button clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '#timebillingModalSelectButton', function (e) {
        NXINVOICE.DOM.addSelectedTimebilling($(this));
    });


    /*----------------------------------------------------------------
     *  [time item] - add task time billing button clicked
     * ------------------------------------------------------------*/
    $(document).on('click', '#tasksModalSelectTimeButton', function (e) {
        //change the 'data-unit' for each selected item to equal the value in 'data-unit-time'
        $("#tasks-list-table").find(".tasks-checkbox:checked").each(function () {
            $(this).attr('data-unit', $(this).attr('data-unit-time'));
        });
        NXINVOICE.DOM.addSelectedTimebilling($(this));
    });



    /*----------------------------------------------------------------
     *  [tax type] - tax type drop down has been changed
     * ------------------------------------------------------------*/
    $(document).on('change keyup input paste', '.calculation-element', function () {
        NXINVOICE.CALC.reclaculateBill(self);
    });


    /*----------------------------------------------------------------
     *  [deciamls] keep 2 deciaml places for all number fields
     * -----------------------------------------------------------*/
    $(".decimal-field").blur(function () {
        this.value = parseFloat(this.value).toFixed(2);
    });


    /*----------------------------------------------------------------
     *  [save changes]
     * ------------------------------------------------------------*/
    $(document).on("click", '#billing-save-button', function () {
        NXINVOICE.CALC.saveBill($(this));
    });


    /*----------------------------------------------------------------
     *  [tax type] - tax type drop down has been changed
     * ------------------------------------------------------------*/
    $(document).on('change keyup input paste', '.js_line_validation_item', function () {
        NXINVOICE.DOM.revalidateItem($(this));
    });


    /*----------------------------------------------------------------
     *  [paynow] button clicked
     * -----------------------------------------------------------*/
    $(document).on('click', '#invoice-make-payment-button', function (e) {
        $("#invoice-buttons-container").hide();
        $("#invoice-pay-container").show();
    });

    //prevent event dropwon from closing on click event
    $(document).on('click', '.top-nav-events', function (e) {
        e.stopPropagation();
    });

    //prevent event dropwon from closing on click event
    $(document).on('click', '.js-do-not-close-on-click', function (e) {
        e.stopPropagation();
    });

    //prevent event dropwon from closing on click of selecte2 on topnav timer
    $(document).on('click', '.js-do-not-close-on-click > .select2-search__field', function (e) {
        e.stopPropagation();
    });



    /*----------------------------------------------------------------
     *  show plan modal window
     * -----------------------------------------------------------*/
    $(document).on('click', '.show-modal-button', function () {
        var title = $(this).attr('data-modal-title');
        //change title (if applicable)
        $("#plainModalTitle").html(title);
        //reset body
        $("#plainModalBody").html('');
        //modal size (modal-lg | modal-sm | modal-xl)
        var modal_size = $(this).attr('data-modal-size');
        if (modal_size == '' || modal_size == null) {
            modal_size = 'modal-lg';
        }
        //set modal size
        $("#plainModalContainer").addClass(modal_size);
    });


    /*----------------------------------------------------------------
     *  show common modal window. This function set the ajax attr
     *  for for the modal window, that has been triggered by a button
     * 
     * -----------------------------------------------------------*/
    $(document).on('click', '.edit-add-modal-button', function () {

        //variables
        var url = $(this).attr('data-url');
        var modal_title = $(this).attr('data-modal-title');
        var action_url = $(this).attr('data-action-url');
        var action_class = $(this).attr('data-action-ajax-class');
        var action_loading_target = $(this).attr('data-action-ajax-loading-target');
        var action_method = $(this).attr('data-action-method');
        var action_type = $(this).attr('data-action-type');
        var action_form_id = $(this).attr('data-action-form-id');
        var add_class = $(this).attr('data-add-class');
        var top_padding = $(this).attr('data-top-padding'); //set to 'none'
        var button_loading_annimation = $(this).attr('data-button-loading-annimation');


        //modal-lg modal-sm modal-xl modal-xs
        var modal_size = $(this).attr('data-modal-size');
        if (modal_size == '' || modal_size == null) {
            modal_size = 'modal-lg';
        }

        //objects
        var $button = $(".commonModalSubmitButton");

        //enable button - incase it was previously disable by another function
        $button.prop("disabled", false);

        //set modal size
        $("#commonModalContainer").removeClass('modal-lg modal-sm modal-xl modal-xs');
        $("#commonModalContainer").addClass(modal_size);

        //update form style
        var form_style = $(this).attr('data-form-design');
        if (form_style != '') {
            //remove previous styles
            $("#commonModalForm").removeClass('form-material')
            $("#commonModalForm").addClass(form_style)
        }

        //add custom class
        if (add_class != '') {
            $("#commonModalContainer").addClass(add_class);
        }


        //change title
        $("#commonModalTitle").html(modal_title);
        //reset body
        $("#commonModalBody").html('');
        //hide footer
        $("#commonModalFooter").hide();
        //change form action
        $("#commonModalForm").attr('action', action_url);


        //[submit button] - reset
        $button.show();
        $button.removeClass('js-ajax-ux-request');
        $button.addClass(action_class);
        $button.attr('data-form-id', 'commonModalBody');

        //defaults
        $("#commonModalHeader").show();
        $("#commonModalFooter").show();
        $("#commonModalCloseButton").show();
        $("#commonModalCloseIcon").show();
        $("#commonModalExtraCloseIcon").hide();

        //remove classes
        $("#commonModalCloseIcon").removeClass('on-close-reload-parent');
        $("#commonModalCloseButton").removeClass('on-close-reload-parent');

        //hidden elements
        if ($(this).attr('data-header-visibility') == 'hidden') {
            $("#commonModalHeader").hide();
        }
        if ($(this).attr('data-footer-visibility') == 'hidden') {
            $("#commonModalFooter").hide();
        }
        if ($(this).attr('data-close-button-visibility') == 'hidden') {
            $("#commonModalCloseButton").hide();
        }
        if ($(this).attr('data-header-close-icon') == 'hidden') {
            $("#commonModalCloseIcon").hide();
        }
        if ($(this).attr('data-header-extra-close-icon') == 'visible') {
            $("#commonModalExtraCloseIcon").show();
        }
        //reload parent when modal is closed
        if ($(this).attr('data-on-close-reload-parent') == 'yes') {
            $("#commonModalCloseIcon").addClass('on-close-reload-parent');
            $("#commonModalCloseButton").addClass('on-close-reload-parent');
        }

        //remove top padding
        if (top_padding == 'none') {
            $("#commonModalBody").addClass('p-t-0');
        } else {
            $("#commonModalBody").removeClass('p-t-0');
        }

        //[submit button] - update attributes etc (if provided)
        //$button.addClass(action_class);
        $button.attr('data-url', action_url);
        $button.attr('data-loading-target', action_loading_target);
        $button.attr('data-ajax-type', action_method);

        //add loading annimation on button
        if (button_loading_annimation == 'yes') {
            $button.attr('data-button-loading-annimation', 'yes');
        }

        //form post
        if (action_type == "form") {
            $button.attr('data-type', 'form');
            $button.attr('data-form-id', action_form_id);
        }
    });

    /*----------------------------------------------------------------
     *  show actions modal window - action modal
     * -----------------------------------------------------------*/
    $(document).on('click', '.actions-modal-button', function () {

        //variables
        var url = $(this).attr('data-url');
        var modal_title = $(this).attr('data-modal-title');
        var action_url = $(this).attr('data-action-url');
        var action_method = $(this).attr('data-action-method');
        var add_body_class = $(this).attr('data-body-class');


        //additional variable
        var action_type = $(this).attr('data-action-type');
        var action_form_id = $(this).attr('data-action-form-id');

        //add class to modal body
        if (add_body_class != '') {
            $("#actionsModalBody").addClass(add_body_class);
        }

        //objects
        var $button = $("#actionsModalButton");

        //change title
        $("#actionsModalTitle").html(modal_title);
        //reset body
        $("#actionsModalBody").html('');
        //hide footer
        $("#actionsModalFooter").hide();

        //$button.addClass(action_class);
        $button.attr('data-url', action_url);
        $button.attr('data-ajax-type', action_method);
        $button.attr('data-type', action_type);
        $button.attr('data-form-id', action_form_id);
        $button.attr('data-skip-checkboxes-reset', true);
    });


    /*----------------------------------------------------------------
     * show category hover button
     *--------------------------------------------------------------*/
    $(document).on('mouseover', '.kb-category', function () {
        $(this).find(".kb-hover-icons").show();
    });
    $(document).on('mouseout', '.kb-category', function () {
        $(this).find(".kb-hover-icons").hide();
    });


    /*----------------------------------------------------------------
     * Better ux on teaks checkbox click
     *--------------------------------------------------------------*/
    $(document).on('click', '.toggle_task_status', function () {
        var parentid = $(this).attr('data-container');
        var parent = $("#" + parentid);
        if ($(this).prop("checked") == true) {
            parent.addClass('task-completed');
        } else {
            parent.removeClass('task-completed');
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  toggle tasks and leads custom fields
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", "#custom-fields-panel-edit-button", function (e) {
        e.preventDefault();
        $(".custom-fields-panel-edit").hide();
        $("#custom-fields-panel").show();
    });
    $(document).on("click", "#custom-fields-panel-close-button", function (e) {
        e.preventDefault();
        $("#custom-fields-panel").hide();
        $(".custom-fields-panel-edit").show();
    });





    /*----------------------------------------------------------------
     *  create modal - start
     * -----------------------------------------------------------*/
    $(document).on('click', '.create-modal-button', function () {


        //set modal splash message
        $("#create-modal-splash-text").html($(this).attr('data-splash-text'));

        //set create url
        $("#create-new-client-button").attr('data-url', $(this).attr('data-new-client-url'));

        //show defauly set
        $(".create-modal-option-contaiers").hide();
        $("#option-existing-client-container").show();


    });


    /*----------------------------------------------------------------
     *  create modal - selector
     * -----------------------------------------------------------*/
    $(document).on('click', '.create-modal-selector', function () {

        var target_containter = $(this).attr('data-target-container');

        //hide all containers
        $(".create-modal-option-contaiers").hide();

        //show the target container
        $("#" + target_containter).show();

    });



    /*----------------------------------------------------------------
     *  create modal - selector
     * -----------------------------------------------------------*/
    $(document).on('click', '.client-type-selector', function () {

        var target_containter = $(this).attr('data-target-container');

        //hide all containers
        $(".client-selector-container").hide();
        $(".client-type-selector").removeClass('active');

        //set clients election type
        $("#client-selection-type").val($(this).attr('data-type'))

        //show the target container
        $("#" + target_containter).show();
        $(this).addClass('active');

        //show custom fields option
        if ($(this).attr('data-type') == 'new') {
            $("#new-client-custom-fields").show();
            //New Client: set to manual mode and disable dropdown
            $("#invoice_due_date_method").val('set_due_date_manually').trigger('change');
            $("#invoice_due_date_method").prop('disabled', true);
            $("#bill_due_date_auto_container").hide();
            $("#bill_due_date_manual_container").removeClass('hidden').show();
        } else {
            $("#new-client-custom-fields").hide();
            //Existing Client: enable dropdown and show manual field
            $("#invoice_due_date_method").prop('disabled', false);
            $("#bill_due_date_manual_container").removeClass('hidden').show();
            $("#bill_due_date_auto_container").hide();
        }

    });


    /*----------------------------------------------------------------
     *  [stop topnav timer] - clicked
     *---------------------------------------------------------------*/
    $(document).on('click', '#my-timer-time-topnav-stop-button', function (e) {
        //hide timer
        $("#my-timer-container-topnav").hide();
    });



    /** --------------------------------------------------------------------------------------------------
     *  [card assigned user - add button clicked]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".card-task-assigned, .card-lead-assigned", function (e) {
        NXCardsAssignedSelect();
    });


    /** --------------------------------------------------------------------------------------------------
     *  [reminder panel] - toggle
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-reminder-panel", function () {
        NX.toggleReminderPanel($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [toggle row with settings on a table] - this is reusable
     *  - settings button must have the following attributes
     *       - [data-settings-row-id] - corresponding to the row with the settings
     *       - [data-settings-common-rows] - a common class for the parent and also settings rows
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-table-settings-row", function () {
        NX.toggleTableSettingsRow($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [custom field] - standard form - required checked box clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("change", ".custom-fields-standard-form-required-checkbox", function () {
        nxAjaxUxRequest($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [custom field] - standard form - how to display the form
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("change", "#custom_fields_display_setting", function () {
        nxAjaxUxRequest($(this));
    });



    /** --------------------------------------------------------------------------------------------------
     *  [cliet modules permissions] - toggle the permissions in add/edit clients modal
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#client_app_modules", function (e) {

        var selection = e.params.data.id;

        //toggle permissions
        if (selection == 'system') {
            $("#client_app_modules_pemissions").hide();
        } else {
            $("#client_app_modules_pemissions").show();
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  [reminders] - close reminder buttom clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", "#close_reminder_button", function () {
        //hide the calendar
        $("#card-reminder-create-container").hide();
        //show add button
        $("#card-reminder-create-button").show();
    });

    /** --------------------------------------------------------------------------------------------------
     *  [reminders] - edit reminder icon
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", "#card-a-reminder-edit-button", function () {
        //show edit button
        $("#card-a-reminder-buttons").toggle();
    });


    /** --------------------------------------------------------------------------------------------------
     *  [top nav reminders - show]
     * -------------------------------------------------------------------------------------------------*/
    $("#topnav-reminders-dropdown").on("show.bs.dropdown", function (e) {
        NX.remindersTopNav($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [top nav reminder - delete one reminder]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.js-reminder-mark-read-single', function (e) {
        NX.remindersMarkRead($(this), 'single');
    });


    /** --------------------------------------------------------------------------------------------------
     *  [top nav reminders - delete all]
     * -------------------------------------------------------------------------------------------------*/
    $("#topnav-reminders-delete-all").on('click', function (e) {
        //aajx request
        nxAjaxUxRequest($(this));
        //hide icon
        $("#topnav-reminders-dropdown").hide();
    });


    /** --------------------------------------------------------------------------------------------------
     *  [tasks/leads] - cancel tags editing button clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", "#card-tags-button-cancel", function () {
        $("#card-tags-edit-tags-container").hide();
        $("#card-tags-current-tags-container").show();
    });
    $(document).on("click", "#card-tags-button-edit", function () {
        $('#card_tags').select2('destroy');
        $('#card_tags').select2(null).trigger("change");

        //reset select2 dropdown
        $('#card_tags').select2({
            theme: "bootstrap",
            width: null,
            containerCssClass: ':all:',
            tags: true,
            multiple: true,
            tokenSeparators: [' '],
        }).val(NX.array_1).trigger("change");
        //show and hide
        $("#card-tags-edit-tags-container").show();
        $("#card-tags-current-tags-container").hide();
    });



    /** --------------------------------------------------------------------------------------------------
     *  [notifications panel] - toggle
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-notifications-panel", function () {
        NXtoggleNotificationsPanel($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [side panel with menu] - menu clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".right-sidepanel-menu", function () {
        $(".right-sidepanel-menu").removeClass('active');
        $(this).addClass('active');
    });



    /** --------------------------------------------------------------------------------------------------
     *  [close side panels] - toggle
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-close-side-panels", function () {
        NXcloseSidePanel($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [projects & milestones] - on selecting project, update the milestones dropdown
     * --------------------------------------------------------------------------------------------------*/
    //client list has been reset or cleared
    $(document).on("select2:unselecting", ".projects_and_milestones_toggle", function (e) {
        NX.projectsAndMilestonesClearToggle($(this));
    });
    //client list has been reset or cleared
    $(document).on("select2:select", ".projects_and_milestones_toggle", function (e) {
        NX.projectsAndMilestonesToggle(e, $(this));
    });




    /*----------------------------------------------------------------
     *  proposals modal - client type selector
     * -----------------------------------------------------------*/
    $(document).on('click', '.customer-type-selector', function () {

        var target_containter = $(this).attr('data-target-container');

        //hide all containers
        $(".customer-selector-container").hide();
        $(".customer-type-selector").removeClass('active');

        //set clients election type
        $("#customer-selection-type").val($(this).attr('data-type'))

        //show the target container
        $("#" + target_containter).show();
        $(this).addClass('active');

    });


    /** --------------------------------------------------------------------------------------------------
     *  [tasks] - creating a new task. Show client users for assignment, when project has been
     *            selected
     * --------------------------------------------------------------------------------------------------*/
    //client list has been reset or cleared
    $(document).on("select2:unselecting", ".projects_assigned_client_toggle", function (e) {
        NXTaskProjectToggleClear($(this));
    });
    //client list has been reset or cleared
    $(document).on("select2:select", ".projects_assigned_client_toggle", function (e) {
        NXTaskProjectToggle(e, $(this));
    });



    /*----------------------------------------------------------------
     *  estimate automation [create project]
     * -----------------------------------------------------------*/
    $(document).on('change', '#settings2_estimates_automation_create_project, #estimate_automation_create_project', function () {
        if ($(this).is(':checked')) {
            $("#settings_automation_create_project_options").show();
            $("#estimate_automation_create_project_options").show();
        } else {
            $("#settings_automation_create_project_options").hide();
            $("#estimate_automation_create_project_options").hide();
        }
    });


    /*----------------------------------------------------------------
     *  estimate automation [create invoice]
     * -----------------------------------------------------------*/
    $(document).on('change', '#settings2_estimates_automation_create_invoice, #estimate_automation_create_invoice', function () {
        if ($(this).is(':checked')) {
            $("#settings_automation_create_invoice_options").show();
            $("#estimate_automation_create_invoice_options").show();
        } else {
            $("#settings_automation_create_invoice_options").hide();
            $("#estimate_automation_create_invoice_options").hide();
        }
    });

    /** --------------------------------------------------------------------------------------------------
     *  estimate automation [default status]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#settings2_estimates_automation_default_status, #automation_default_status, #estimate_automation_status", function (e) {

        var selection = e.params.data.id;
        //toggle permissions
        if (selection == 'enabled') {
            $("#settings-automation-options-container").show();
            $("#automation-options-container").show();
        } else {
            $("#settings-automation-options-container").hide();
            $("#automation-options-container").hide();
        }
    });



    /** --------------------------------------------------------------------------------------------------
     *  project automation [default status]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#settings2_projects_automation_default_status, #automation_default_status, #project_automation_status", function (e) {

        var selection = e.params.data.id;
        //toggle permissions
        if (selection == 'enabled') {
            $("#automation-options-container").show();
        } else {
            $("#automation-options-container").hide();
        }
    });


    /*----------------------------------------------------------------
     *  project automation [create invoice]
     * -----------------------------------------------------------*/
    $(document).on('change', '#settings2_projects_automation_create_invoices, #project_automation_create_invoices', function () {
        if ($(this).is(':checked')) {
            $("#project_automation_create_invoices_settings").show();
        } else {
            $("#project_automation_create_invoices_settings").hide();
        }
    });

    /*----------------------------------------------------------------
     *  project automation [create invoice]
     * -----------------------------------------------------------*/
    $(document).on('change', '#settings2_projects_automation_convert_estimates_to_invoices', function () {
        if ($(this).is(':checked')) {
            $("#project_automation_create_invoices_options").show();
        } else {
            $("#project_automation_create_invoices_options").hide();
        }
    });


    /*----------------------------------------------------------------
     *  project automation [bill hours]
     * -----------------------------------------------------------*/
    $(document).on('change', '#settings2_projects_automation_invoice_unbilled_hours, #project_automation_invoice_unbilled_hours', function () {
        if ($(this).is(':checked')) {
            $("#project_automation_invoice_hourly_rate_container").show();
        } else {
            $("#project_automation_invoice_hourly_rate_container").hide();
        }
    });


    /*----------------------------------------------------------------
     *  task dependency
     * -----------------------------------------------------------*/
    //create button clicked
    $(document).on('click', '#card-dependency-create-button', function () {
        //show the form
        $("#task-dependency-list-container").hide();
        $("#task-dependency-create-container").show();
    });
    //close button clicked
    $(document).on('click', '#card-task-dependency-close-button', function () {
        //show the form
        $("#task-dependency-create-container").hide();
        $("#task-dependency-list-container").show();
    });
    //delete dependency button clicked
    $(document).on('click', '#task-dependency-delete-button', function () {
        var parent = $(this).attr('data-parent');
        $("#" + parent).hide();
        nxAjaxUxRequest($(this));
    });
    $(document).on('click', '#task-dependency-delete-button', function () {
        var parent = $(this).attr('data-parent');
        //show the form
        $("#" + parent).hide();
    });



    /** --------------------------------------------------------------------------------------------------
     *  [file folders settings] - toggle status
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#settings2_file_folders_status", function (e) {

        var selection = e.params.data.id;

        //toggle permissions
        if (selection == 'enabled') {
            $("#file_folders_managers").show();
        } else {
            $("#file_folders_managers").hide();
        }
    });



    /** --------------------------------------------------------------------------------------------------
     *  [file folder menu]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.file-folder-menu-item', function (e) {
        $(".file-folder-menu-item").removeClass('active');
        $(this).addClass('active');
    });


    /** --------------------------------------------------------------------------------------------------
     *  [estimate automation] - accept estimate - set project title
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#bill_status", function (e) {

        var selection = e.params.data.id;

        if (selection == 'accepted') {
            $("#estimate_automation_project_title_panel").show();
        } else {
            $("#estimate_automation_project_title_panel").hide();
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  [product type selector] - toggle type
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#item_type", function (e) {

        var selection = e.params.data.id;

        //toggle permissions
        if (selection == 'dimensions') {
            $("#items_dimensions_container").show();
        } else {
            $("#items_dimensions_container").hide();
        }
    });


    /**--------------------------------------------------------------------------------------
     * [ITEMS SIDE PANEL] - for managing product's tasks for automation
     * -------------------------------------------------------------------------------------*/
    $(document).ready(function () {
        $(document).on('click', '#js-products-automation-tasks', function () {
            //reset the side panel content
            $("#products-tasks-side-panel-content").html('');
            //add link to the 'create task'button
            $("#create-product-task-button").attr('data-url', $(this).attr('data-create-task-url'));
            $("#create-product-task-button").attr('data-action-url', $(this).attr('data-create-task-action-url'));
            //loadajax
            nxAjaxUxRequest($(this));
        });
    });


    /**--------------------------------------------------------------------------------------
     * [ESTIMATE FILE ATTACHMENTS
     * -------------------------------------------------------------------------------------*/
    $(document).ready(function () {
        //toggle dropzone
        $(document).on('click', '#bill-file-attachments-upload-button', function () {
            $("#bill-file-attachments-wrapper").hide();
            $("#bill-file-attachments-dropzone-wrapper").show();
        });
        $(document).on('click', '#bill-file-attachments-close-button', function (event) {
            event.stopPropagation();
            $("#bill-file-attachments-dropzone-wrapper").hide();
            $("#bill-file-attachments-wrapper").show();
        });

        //delet file attachment
        $(document).on('click', '#delete-bill-file-attachment', function () {
            var parent = $(this).attr('data-parent');
            $("#" + parent).hide();
            nxAjaxUxRequest($(this));
        });
    });


    /** ----------------------------------------------------------
     *  [jquery.confirm] [option 1]
     *     - form fields in confirm dialogue (such as check boxes)
     * -----------------------------------------------------------*/
    //set the form value to the actual form value
    $(document).on('change', '.saas_email_option', function () {

        //reset all 
        $('.saas_email_option').prop('checked', false);
        $('.email_settings').hide();

        //check this one
        $(this).prop('checked', true);

        //hidden field
        $("#" + $(this).attr('data-target')).show();

    });

    /** --------------------------------------------------------------------------------------------------
     *  [tickets] - reply inline
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#ticket_replay_button_inline', function (e) {

        // Destroy existing dropzone instance on the target element
        var $dropzoneElement = $("#fileupload_ticket_reply");
        var existingDropzoneInstance = $dropzoneElement.get(0).dropzone;
        if (existingDropzoneInstance) {
            existingDropzoneInstance.destroy();
        }

        //enable dropzone
        $("#fileupload_ticket_reply").dropzone({
            url: "/fileupload",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function () {
                this.on("error", function (file, message, xhr) {

                    //is there a message from backend [abort() response]
                    if (typeof xhr != 'undefined' && typeof xhr.response != 'undefined') {
                        var error = $.parseJSON(xhr.response);
                        var message = error.notification.value;
                    }

                    //any other message
                    var message = (typeof message == 'undefined' || message == '' ||
                        typeof message == 'object') ? NXLANG.generic_error : message;

                    //error message
                    NX.notification({
                        type: 'error',
                        message: message
                    });
                    //remove the file
                    this.removeFile(file);
                });
            },
            success: function (file, response) {
                //get the priview box dom elemen
                var $preview = $(file.previewElement);
                //create a hidden form field for this file
                $preview.append('<input type="hidden" name="attachments[' + response.uniqueid +
                    ']"  value="' + response.filename + '">');
            }
        });

        // Loop through each TinyMCE instance
        tinymce.editors.forEach(function (editor) {
            // Set the content to an empty string
            editor.setContent('');
        });

        $("#ticket_replay_button_inline_container").hide();
        $("#ticket_reply_inline_form").show();

        //reply or note
        var reply_type = $(this).attr('data-reply-type');
        $("#ticketreply_type").val(reply_type);
        if (reply_type == 'note') {
            $("#ticketreply_type_info").show();
            //change the lang on the submit button
            var reply_button_text = $("#ticket_reply_button_submit").attr('data-lang-save-note');
            $("#ticket_reply_button_submit").html(reply_button_text);
            $("#ticket-add-canned").hide();
        } else {
            $("#ticketreply_type_info").hide();
            //change the lang on the submit button
            var reply_button_text = $("#ticket_reply_button_submit").attr('data-lang-submit');
            $("#ticket_reply_button_submit").html(reply_button_text);
            $("#ticket-add-canned").show();
        }

    });

    $(document).on('click', '#ticket_reply_button_close', function (e) {
        $("#ticket_reply_inline_form").hide();
        $("#ticket_replay_button_inline_container").show();
    });


    /** --------------------------------------------------------------------------------------------------
     *  [tickets] - edit reply - cancel button
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#ticket_edit_reply_cancel_buton', function (e) {


        var text_container_id = $(this).attr('data-reply-text-container');
        var text_editor_container_id = $(this).attr('data-edit-reply-container');

        //hide the text editor container
        $("#" + text_editor_container_id).hide();

        //show the original text
        $("#" + text_container_id).show();

    });

    /** --------------------------------------------------------------------------------------------------
     *  clear preset filter
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#clear_preset_filter_button', function (e) {
        $("#clear_preset_filter_button_container").hide();
        ("#filter_remember").prop('checked', false);
    });

    /** --------------------------------------------------------------------------------------------------
     *  reports date range option selected
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#filter_report_date_range", function (e) {
        var selected_value = e.params.data.id;
        if (selected_value == 'custom_range') {
            $(".reports-date-range").show();
        } else {
            $(".reports-date-range").hide();
        }
    });

    /** --------------------------------------------------------------------------------------------------
     *  [table config panel] - toggle
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-table-config-panel", function () {
        NX.toggleTableConfigPanel($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  [table config panel] - checkbox clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).ready(function () {
        $(document).on('click', '.table-config-checkbox', function () {

            var column_class = $(this).attr('name');
            var $table_column = $("." + column_class);

            //toggle table column
            if ($(this).is(':checked')) {
                $table_column.removeClass('hidden');
            } else {
                $table_column.addClass('hidden');
            }


            nxAjaxUxRequest($(this).closest('.table-config-ajax'));
        });
    });




    /*----------------------------------------------------------------
     *  reset any modal body
     * -----------------------------------------------------------*/
    $(document).on('click', '.reset-target-modal', function () {

        var target_id = $(this).data('target');
        var target = $(target_id + 'Body');

        target.html('');

    });

    /** ----------------------------------------------------------
     *  invoices/estimates bulk adding category items
     * -----------------------------------------------------------*/
    //set the form value to the actual form value
    $(document).on('change', '.category-items-checkbox', function () {

        var target = $(this).attr('data-target');

        if ($(this).is(':checked')) {
            //check all target items
            $(target).prop('checked', true);

        } else {
            //check all target items
            $(target).prop('checked', false);
        }
    });


    /*----------------------------------------------------------------
     * dashboard - income expenses chart tooltip
     *--------------------------------------------------------------*/
    $(document).ready(function () {
        $(".chartist-tooltip").html('---');
    });
    $(document).on('mouseout', '#admin-dhasboard-income-vs-expenses', function () {
        $(this).find(".chartist-tooltip").hide();
    });
    $(document).on('mouseover', '#admin-dhasboard-income-vs-expenses', function () {
        $(this).find(".chartist-tooltip").show();
    });

    /** --------------------------------------------------------------------------------------------------
     *  prevent events from bubbling down
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-close-dropdown-onclick", function (event) {
        event.stopPropagation();
    });


    /** --------------------------------------------------------------------------------------------------
     *  publishing - scheduled or now
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".publishing_option", function (event) {
        // uncheck all other checkboxes with the same class
        $('.publishing_option').not(this).prop('checked', false);
        // check the currently clicked checkbox
        $(this).prop('checked', true);

        //enable check box
        if ($(this).attr('id') == 'publishing_option_later') {
            $('.publishing_option_date').prop('disabled', false);
            $("#publishing_option_button").html($("#publishing_option_button").attr('data-lang-schedule'));
        } else if ($(this).attr('id') == 'publishing_option_now') {
            $('.publishing_option_date').prop('disabled', true);
            $("#publishing_option_button").html($("#publishing_option_button").attr('data-lang-publish'));
        }
    });

    //submit button has been clicked. select appropriate action
    $(document).on("click", "#publishing_option_button", function (event) {

        //publish now
        if ($('#publishing_option_now').prop('checked')) {
            //start request
            nxAjaxUxRequest($("#publishing_option_now"));
        } else {
            //start request
            nxAjaxUxRequest($("#publishing_option_later"));
        }

        //close drop down
        $('.dropdown-menu').dropdown('hide');
    });

    /** --------------------------------------------------------------------------------------------------
     *  canned messages - expand button cliked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-canned-button-expand", function (event) {

        var target_meta = $(this).data('meta');
        var target_body = $(this).data('body');
        var arrow_up = $(this).data('up');
        var arrow_down = $(this).data('down');

        var dom_target_meta = $("#" + target_meta);
        var dom_target_body = $("#" + target_body);
        var dom_arrow_up = $("#" + arrow_up);
        var dom_arrow_down = $("#" + arrow_down);

        //reset default
        $(".canned-meta").show();
        $(".canned-icon-up").hide();
        $(".canned-icon-down").show();

        // Check if the target body is visible
        if (dom_target_body.is(":visible")) {
            $(".canned-body").hide();
            dom_arrow_up.hide();
            dom_arrow_down.show();
            dom_target_body.hide();
            dom_target_meta.show();
        } else {
            $(".canned-body").hide();
            dom_arrow_up.show();
            dom_arrow_down.hide();
            dom_target_body.show();
            dom_target_meta.hide();
        }

    });


    /** --------------------------------------------------------------------------------------------------
     *  canned messages - insert message button cliked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-canned-button-insert", function (event) {

        var message = $(this).data('body');
        var $message = $("#" + message);

        //reset panel default
        $(".canned-meta").show();
        $(".canned-icon-up").hide();
        $(".canned-icon-down").show();
        $(".canned-body").hide();

        // reset content of the TinyMCE editor
        tinymce.activeEditor.setContent('');

        // get the content from the canned-response div
        var canned_response = $message.html();

        // insert the canned response into the TinyMCE editor
        tinymce.activeEditor.execCommand('mceInsertContent', false, canned_response);

        //record last uses
        nxAjaxUxRequest($(this));

        //close panel
        NXcloseSidePanel();

    });



    /** --------------------------------------------------------------------------------------------------
     *  canned messages - search form filled
     * -------------------------------------------------------------------------------------------------*/
    let canned_timeout;
    $(document).on('keyup', '#search_canned', function (e) {

        //reset category dropdown
        $("#browse_canned").val('');
        $("#browse_canned").trigger("change");

        // check if the input field is focused and the Enter key is pressed - execute search now
        if ($(this).is(':focus') && e.keyCode === 13) {
            clearTimeout(canned_timeout);
            nxAjaxUxRequest($(this));
        } else {
            // if other keys are pressed execute dynamic search after a delay
            clearTimeout(canned_timeout);
            canned_timeout = setTimeout(() => {
                if ($('#search_canned').is(':focus')) {
                    NX.dynamicSearch($(this), e);
                }
            }, 1000);
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  canned messages - category dropdown selected
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#browse_canned", function (e) {
        //reset search form
        $("#search_canned").val('');
        //request
        nxAjaxUxRequest($(this));
    });


    /** --------------------------------------------------------------------------------------------------
     *  proposal automation [default status]
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#settings2_proposals_automation_default_status, #automation_default_status, #proposal_automation_status", function (e) {

        var selection = e.params.data.id;
        //toggle permissions
        if (selection == 'enabled') {
            $("#settings-automation-options-container").show();
            $("#automation-options-container").show();
        } else {
            $("#settings-automation-options-container").hide();
            $("#automation-options-container").hide();
        }
    });

    /*----------------------------------------------------------------
     *  [contracts] automation - show/hide settings
     * --------------------------------------------------------------*/
    $(document).on("select2:select", "#settings2_contracts_automation_default_status, #automation_default_status, #contract_automation_status", function (e) {

        var selection = e.params.data.id;
        //toggle permissions
        if (selection == 'enabled') {
            $("#settings-automation-options-container").show();
            $("#automation-options-container").show();
        } else {
            $("#settings-automation-options-container").hide();
            $("#automation-options-container").hide();
        }
    });

    /*----------------------------------------------------------------
     *  contracts automation [create project]
     * -----------------------------------------------------------*/
    $(document).on('change', '#settings2_contracts_automation_create_project, #contract_automation_create_project', function () {
        if ($(this).is(':checked')) {
            $("#settings_automation_create_project_options").show();
            $("#contract_automation_create_project_options").show();
        } else {
            $("#settings_automation_create_project_options").hide();
            $("#contract_automation_create_project_options").hide();
        }
    });

    /*----------------------------------------------------------------
     *  contracts automation [create invoice]
     * -----------------------------------------------------------*/
    $(document).on('change', '#settings2_contracts_automation_create_invoice, #contract_automation_create_invoice', function () {
        if ($(this).is(':checked')) {
            $("#settings_automation_create_invoice_options").show();
            $("#contract_automation_create_invoice_options").show();
        } else {
            $("#settings_automation_create_invoice_options").hide();
            $("#contract_automation_create_invoice_options").hide();
        }
    });

    /*----------------------------------------------------------------
     *  proposal automation [create project]
     * -----------------------------------------------------------*/
    $(document).on('change', '#settings2_proposals_automation_create_project, #proposal_automation_create_project', function () {
        if ($(this).is(':checked')) {
            $("#settings_automation_create_project_options").show();
            $("#proposal_automation_create_project_options").show();
        } else {
            $("#settings_automation_create_project_options").hide();
            $("#proposal_automation_create_project_options").hide();
        }
    });


    /*----------------------------------------------------------------
     *  tickets IMAP settings
     * -----------------------------------------------------------*/
    $(document).on('select2:select', '#settings2_tickets_imap_status', function (e) {
        var selection = e.params.data.id;
        if (selection == 'enabled') {
            $("#settings_imap_options_container").show();
            $("#imap_test_connection_button").show();
        } else {
            $("#settings_imap_options_container").hide();
            $("#imap_test_connection_button").hide();
        }
    });


    /*----------------------------------------------------------------
     *  tickets IMAP category settings
     * -----------------------------------------------------------*/
    $(document).on('select2:select', '#category_email_integration', function (e) {
        var selection = e.params.data.id;
        if (selection == 'enabled') {
            $("#category_imap_settings_container").show();
        } else {
            $("#category_imap_settings_container").hide();
        }
    });

    /** --------------------------------------------------------------------------------------------------
     *  pinning items
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-pinning", function (e) {

        e.preventDefault();

        var parent_id = $(this).attr('data-parent');
        var $parent = $("#" + parent_id);

        //disable the items
        $parent.addClass('disabled-content');

        //request
        nxAjaxUxRequest($(this));
        e.stopPropagation();
    });

    /** --------------------------------------------------------------------------------------------------
     *  checlist items - show drag icon, on-hover
     * -------------------------------------------------------------------------------------------------*/
    $(document).ready(function () {
        // When the mouse enters a checklist item
        $(document).on('mouseenter', '.checklist-item', function () {
            // Find the .drag-handle element within this checklist item and show it
            $(this).find('.drag-handle').show();
        });

        // When the mouse leaves a checklist item
        $(document).on('mouseleave', '.checklist-item', function () {
            // Find the .drag-handle element within this checklist item and hide it
            $(this).find('.drag-handle').hide();
        });
    });

    /** --------------------------------------------------------------------------------------------------
     *  reload parent on modal window close
     * -------------------------------------------------------------------------------------------------*/
    $(document).off("click", ".on-close-reload-parent").on("click", ".on-close-reload-parent", function (e) {

        //add overlay to page
        $("body").addClass('overlay');
        $("#main-top-nav-bar").addClass('loading');

        //reload window
        window.location.reload();

    });



    /** --------------------------------------------------------------------------------------------------
     *  recording timesheet for other users
     * -------------------------------------------------------------------------------------------------*/
    //monitor select2 change on timesheet user dropdown    
    $(document).on('select2:select', "#timesheet_user", function (e) {
        //get the selected user id
        var userId = $(this).select2('data')[0].id;

        //get the base url from the data attribute
        var baseUrl = $(this).attr('data-base-url');

        //new ajax url
        var newUrl = baseUrl + userId;

        //update the data attribute for consistency
        $("#my_assigned_projects").attr('data-ajax--url', newUrl);

        //update the data attribute for consistency
        $("#my_assigned_projects").attr('data-user-id', userId);

        //update the AJAX URL directly in the select2 instance
        $("#my_assigned_projects").data('select2').dataAdapter.ajaxOptions.url = newUrl;

        //reset the projects dropdown
        $("#my_assigned_projects").val(null).trigger('change');

        //clear and disable the tasks dropdown
        $("#my_assigned_tasks").empty().prop('disabled', true);
    });


    /** --------------------------------------------------------------------------------------------------
     *  import checklist items
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", "#import-checklist-link", function (e) {
        e.preventDefault();

        // Toggle visibility of #import-checklist-container
        if ($("#import-checklist-container").hasClass('hidden')) {
            $("#import-checklist-container").removeClass('hidden');
        } else {
            $("#import-checklist-container").addClass('hidden');
        }

        //hide text area for adding checklist
        $("#element-checklist-text").hide();
    });


    /** --------------------------------------------------------------------------------------------------
     *  [CHECKLIST COMMENTS] - toggle checklist comments wrapper visibility
     *  -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".checklist-comments-wrapper-toggle-button", function (e) {
        e.preventDefault();

        //toggle text aread
        var text_area_wrapper_id = $(this).attr('data-checklist-comments-textarea-wrapper');

        if ($("#" + text_area_wrapper_id).is(":visible")) {
            $(".checklist-comments-textarea-wrapper").hide();
        } else {
            $(".checklist-comments-textarea-wrapper").hide();
            $("#" + text_area_wrapper_id).show();
        }

    });

    /** --------------------------------------------------------------------------------------------------
     *  [CHECKLIST COMMENTS] - submit checklist comment
     *  -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".checklist-comments-submit-button", function (e) {

        //nothing for now

    });

    /** --------------------------------------------------------------------------------------------------
     *  [CHECKLIST COMMENTS] - close post comment textarea
     *  -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".checklist-comments-close-button", function (e) {
        e.preventDefault();

        var tinymce_textarea_id = $(this).attr('data-tinymce-textarea-id');
        var textarea_wrapper = $(this).attr('data-textarea-wrapper');
        var post_button = $(this).attr('data-checklist-comments-post-button');

        // hide the textarea wrapper
        $("#" + textarea_wrapper).hide();

        // show the 'post comment' button
        $("#" + post_button).show();

        // reset the tinymce textarea
        tinymce.get(tinymce_textarea_id).setContent('');

    });


    /** --------------------------------------------------------------------------------------------------
     *  [CHECKLISTS] - hide or show checklist comments
     *  -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".checklist-comments-hide-button", function (e) {

        console.log('foo');

        $("#card-checklist").removeClass('checklist-comments-visible');
        $("#card-checklist").addClass('checklist-comments-hidden');

        $(".global-checklist").removeClass('checklist-comments-visible');
        $(".global-checklist").addClass('checklist-comments-hidden');

    });
    $(document).on("click", ".checklist-comments-show-button", function (e) {

        $("#card-checklist").removeClass('checklist-comments-hidden');
        $("#card-checklist").addClass('checklist-comments-visible');

        $(".global-checklist").removeClass('checklist-comments-hidden');
        $(".global-checklist").addClass('checklist-comments-visible');
    });


    /** --------------------------------------------------------------------------------------------------
     *  [GLOBAL][CHECKLISTS] - add new button clicked
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#checklist-add-new-button, #new-checklist-text-form-close-button', function (e) {
        $("#new-checklist-text-container").toggle();
        $("#checklists-actions-panel").toggle();
        if (!$("#import-checklist-container").hasClass('hidden')) {
            $("#import-checklist-container").addClass('hidden');
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  [CHECKLIST INLINE EDITING] - when user clicks on checklist text to edit
     *  -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".checklist-text-container", function (e) {
        e.preventDefault();

        // First, hide all checklist editing forms that may be open
        $(".edit-checklist-text-container").hide();

        // Show all checklists (go to default view state)
        $(".checklist-item").removeClass('hidden-forced');

        // Get the target editing container ID from data attribute
        var targetEditContainer = $(this).attr('data-target');

        // Get the current checklist container ID
        var checklistContainerId = $(this).closest('.checklist-item').attr('id');

        // Hide the current checklist container
        $("#" + checklistContainerId).addClass('hidden-forced');

        // Show the editing form for this checklist
        $("#" + targetEditContainer).show();
    });

    /** --------------------------------------------------------------------------------------------------
     *  [CHECKLIST INLINE EDITING] - when user clicks update button to save changes
     *  -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".update-checklist-submit-button", function (e) {
        e.preventDefault();

        // Get data attributes
        var checklistTarget = $(this).attr('data-checklist-target');
        var checklistWrapperTarget = $(this).attr('data-checklist-wrapper-target');
        var formId = $(this).attr('data-form-id');

        // Get the new text from textarea
        var newText = $("#" + formId + " textarea[name='checklist_text']").val();

        // Update the checklist text display
        $("#" + checklistTarget).text(newText);

        // Hide the editing form
        $("#" + formId).hide();

        // Show the main checklist container
        $("#" + checklistWrapperTarget).removeClass('hidden-forced');

        // Initiate AJAX request to update backend
        nxAjaxUxRequest($(this));
    });

    /** --------------------------------------------------------------------------------------------------
     *  [CHECKLIST INLINE EDITING] - when user clicks close button to cancel editing
     *  -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".update-checklist-close-button", function (e) {
        e.preventDefault();

        // Get data attributes
        var checklistTarget = $(this).attr('data-checklist-target');
        var textareaTarget = $(this).attr('data-textarea-target');
        var formId = $(this).attr('data-form-id');
        var checklistWrapperTarget = $(this).attr('data-checklist-wrapper-target');

        // Get the original text from the checklist display
        var originalText = $("#" + checklistTarget).text();

        // Reset the textarea to match the original text
        $("#" + textareaTarget).val(originalText);

        // Hide the editing form
        $("#" + formId).hide();

        // Show the main checklist container
        $("#" + checklistWrapperTarget).removeClass('hidden-forced');
    });


    /** --------------------------------------------------------------------------------------------------
     *  [LEAD LOG] - editor close button clicked
     *  -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.lead_log_edit_clode_button', function () {

        var log_id = $(this).attr('data-log-id');
        var lead_log_container = $("#lead_log_container_" + log_id);
        var editor_container = $("#lead_log_editing_wrapper_" + log_id);

        //hide this editor
        editor_container.hide();

        //show the original log
        lead_log_container.show();
    });


    /** --------------------------------------------------------------------------------------------------
     *  [Quick Access] buttons - Star/Unstar toggle
     *  -------------------------------------------------------------------------------------------------*/
    //handle star button click
    $(document).on('click', '#quick-access-star-button', function () {
        //hide star button and show unstar button after successful ajax
        $(this).addClass('ajax-success-action');
        $(this).attr('data-success-hide', '#quick-access-star-button');
        $(this).attr('data-success-show', '#quick-access-unstar-button');
    });

    //handle unstar button click  
    $(document).on('click', '#quick-access-unstar-button', function () {
        //hide unstar button and show star button after successful ajax
        $(this).addClass('ajax-success-action');
        $(this).attr('data-success-hide', '#quick-access-unstar-button');
        $(this).attr('data-success-show', '#quick-access-star-button');
    });


    /*----------------------------------------------------------------
     *  Select2 events - Income vs Expenses Year Filter
     * -----------------------------------------------------------*/
    $(document).on("select2:select", "#income_expenses_year", function (e) {

        //get the selected option value
        var selected_value = e.params.data.id;

        //trigger ajax request using existing framework
        nxAjaxUxRequest($(this));

    });



    /** --------------------------------------------------------------------------------------------------
     *  [STARRED CONTENT] - HIGHLIGHT ACTIVE MENU
     *  Highlight the active menu item in the starred side panel when opened from topnav
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-toggle-side-panel-ajax", function (e) {
        //get the target menu from data attribute
        var targetMenu = $(this).attr('data-target-menu');

        //remove active class from all menu items
        $('.right-sidepanel-menu').removeClass('active');

        //add active class to the target menu item
        if (targetMenu) {
            $('#' + targetMenu).addClass('active');
        }
    });

    /** --------------------------------------------------------------------------------------------------
     *  [STARRED CONTENT] - SORTING DROPDOWN
     *  Update the dropdown text when sorting is changed
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-starred-sorting", function (e) {
        e.preventDefault();

        //get the sort text
        var sortText = $(this).attr('data-sort-text');

        //update the dropdown button text
        $('#starred-sort-text').text(sortText);
    });

    /** --------------------------------------------------------------------------------------------------
     *  [STARRED CONTENT] - REMOVE ITEM FROM FEED
     *  Generic handler to remove items from any starred feed
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", ".js-starred-remove-item", function (e) {
        e.preventDefault();
        e.stopPropagation();

        //get the item id to remove
        var itemId = $(this).attr('data-item-id');

        //fade out and remove the item immediately for better UX
        if (itemId) {
            $('#' + itemId).fadeOut(300, function () {
                $(this).remove();
            });
        }
    });


    /** --------------------------------------------------------------------------------------------------
     *  [SORTABLE TABLES]
     * -------------------------------------------------------------------------------------------------*/
    if ($(".table-sortable").length) {
        $(".table-sortable").tablesorter();
    }


    /** --------------------------------------------------------------------------------------------------
     *  [print] - print a page DOM element
     * @source https://github.com/jasonday/printThis
     * @version v1.15.0
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.js-print-page', function (e) {

        var dom_id = $(this).attr('data-dom-element');

        var page = $("#" + dom_id);

        // validate the table exists
        if (page.length == 0) {

            //error message
            NX.notification({
                type: 'error',
                message: NXLANG.generic_error
            });

            return;
        }

        //print the table
        page.printThis({
            beforePrint: function () {
                $("body").addClass("printing-css");
            },
            afterPrint: function () {
                $("body").removeClass("printing-css");
            },
            debug: false,
        });
    });


    /** --------------------------------------------------------------------------------------------------
     *  [OPTION CHECKBOXES]
     *  Using checkbox to select a single option
     * -------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.option-checkbox', function () {

        //uncheck all check boxes
        $(".option-checkbox").prop("checked") == false;

        //check only this checkbox
        $(this).prop("checked") == true;
    });


    /** -------------------------------------------------------------------------------------------------
     *  [INVOICE DUE DATE] - Toggle between automatic and manual mode
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#invoice_due_date_method", function (e) {
        var selected_value = e.params.data.id;

        if (selected_value === 'set_due_date_manually') {
            //Hide automatic display, show manual datepicker
            $("#bill_due_date_auto_container").hide();
            $("#bill_due_date_manual_container").removeClass('hidden').show();
            //Clear the hidden field in automatic container
            $("#bill_due_date_auto_container").find("#bill_due_date").val('');
        } else {
            //Show automatic display, hide manual datepicker
            $("#bill_due_date_manual_container").hide().addClass('hidden');
            $("#bill_due_date_auto_container").show();
            //Clear manual datepicker values
            $("#bill_due_date_manual").val('');
            $("#bill_due_date_manual_container").find("#bill_due_date").val('');
            //Recalculate automatic due date
            calculateInvoiceDueDate();
        }
    });

    /** -------------------------------------------------------------------------------------------------
     *  [INVOICE DUE DATE] - Recalculate when client changes (automatic mode only)
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("select2:select", "#bill_clientid", function (e) {
        var client_id = $(this).val();

        //Set dropdown to automatic mode and update select2 display
        $("#invoice_due_date_method").val('set_due_date_automatically').trigger('change.select2');

        //Enable dropdown
        $("#invoice_due_date_method").prop('disabled', false);

        //Show automatic field, hide manual field
        $("#bill_due_date_auto_container").show();
        $("#bill_due_date_manual_container").hide().addClass('hidden');

        //Clear manual field values
        $("#bill_due_date_manual").val('');
        $("#bill_due_date_manual_container").find("#bill_due_date").val('');

        //Make AJAX request to get client's due days
        if (client_id) {
            $.ajax({
                url: '/invoices/client-due-days/' + client_id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.due_days !== undefined) {
                        //Update data attribute
                        $("#bill_due_date_display").attr('data-invoice-due-days', response.due_days);
                        //Recalculate with new client's due days
                        calculateInvoiceDueDate();
                    }
                },
                error: function() {
                    //On error, use system default
                    var system_default = $("#bill_due_date_display").data('system-default') || 7;
                    $("#bill_due_date_display").attr('data-invoice-due-days', system_default);
                    calculateInvoiceDueDate();
                }
            });
        }
    });

    /** -------------------------------------------------------------------------------------------------
     *  [INVOICE DUE DATE] - Recalculate when invoice date changes (automatic mode only)
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("change", "#bill_date_add_edit, .pickadate[name='bill_date_add_edit']", function () {
        //Only recalculate if in automatic mode
        if ($("#invoice_due_date_method").val() === 'set_due_date_automatically') {
            calculateInvoiceDueDate();
        }
    });

    /** -------------------------------------------------------------------------------------------------
     *  [INVOICE DUE DATE] - Calculate automatic due date
     * -------------------------------------------------------------------------------------------------*/
    window.calculateInvoiceDueDate = function() {
        var client_id = $("#bill_clientid").val();
        var invoice_date = $("#bill_date_add_edit").next(".mysql-date").val();

        //If no invoice date set, use today's date
        if (!invoice_date || invoice_date === '') {
            var today = new Date();
            invoice_date = today.getFullYear() + '-' +
                          String(today.getMonth() + 1).padStart(2, '0') + '-' +
                          String(today.getDate()).padStart(2, '0');
        }

        //Get due days from data attribute (client specific or system default)
        var due_days = parseInt($("#bill_due_date_display").attr('data-invoice-due-days')) ||
                       parseInt($("#bill_due_date_display").data('system-default')) || 7;

        //Update display with system default or client specific
        updateDueDateDisplay(invoice_date, due_days);
    }

    /** -------------------------------------------------------------------------------------------------
     *  [INVOICE DUE DATE] - Update display text and hidden field
     * -------------------------------------------------------------------------------------------------*/
    function updateDueDateDisplay(invoice_date, due_days) {
        //Calculate due date
        var date = new Date(invoice_date);
        date.setDate(date.getDate() + due_days);

        var due_date_mysql = date.getFullYear() + '-' +
                            String(date.getMonth() + 1).padStart(2, '0') + '-' +
                            String(date.getDate()).padStart(2, '0');

        //Update display text
        var day_label = (due_days !== 1) ? NXLANG.days : NXLANG.day;
        var display_text = NXLANG.invoice_date_plus + " " + due_days + " " + day_label;
        $("#bill_due_date_display").val(display_text);

        //Update hidden field
        $("#bill_due_date_auto_container").find("#bill_due_date").val(due_date_mysql);
    }


});

/** -------------------------------------------------------------------------------------------------
 *  [INVOICE DUE DATE] - Initialize due date calculation on create modal load
 *  Called as postrun function from CreateResponse
 * -------------------------------------------------------------------------------------------------*/
function NXInvoiceCalculateInitialDueDate() {
    //Check if creating from client profile (due days text is pre-calculated)
    var dueDaysText = $("#js-trigger-invoices-modal-add-edit").data('due-days-text');

    if (dueDaysText) {
        //Use pre-calculated text and set to automatic mode
        $("#bill_due_date_display").val(dueDaysText);
        $("#invoice_due_date_method").val('set_due_date_automatically').trigger('change.select2');

        //Also calculate and set the actual due date in hidden field
        if ($("#bill_due_date_display").length) {
            calculateInvoiceDueDate();
        }
    } else {
        //Normal flow - calculate from system defaults
        if ($("#bill_due_date_display").length) {
            calculateInvoiceDueDate();
        }
    }
}


/** --------------------------------------------------------------------------------------------------
 *  [CLICK TO COPY URL] - Copy URL to clipboard
 *  @notes: Reusable function for copying URLs to clipboard
 *  @usage: Add class 'click-to-copy-url' to any element with data-url attribute
 * -------------------------------------------------------------------------------------------------*/
$(document).on('click', '.click-to-copy-url', function(e) {
    //prevent event bubbling
    e.stopPropagation();

    //reference to the clicked element
    var $element = $(this);

    //get the URL from data attribute
    var url_to_copy = $element.attr('data-url');

    //check if URL exists
    if (!url_to_copy) {
        return;
    }

    //copy to clipboard using modern clipboard API
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url_to_copy).then(function() {
            //show centered tooltip notification
            NXShowCopyNotification();
        }).catch(function() {
            //show error in console
            console.error('Failed to copy URL to clipboard');
        });
    } else {
        //fallback for older browsers
        var temp_input = $('<input>');
        $('body').append(temp_input);
        temp_input.val(url_to_copy).select();
        document.execCommand('copy');
        temp_input.remove();

        //show centered tooltip notification
        NXShowCopyNotification();
    }
});

/** --------------------------------------------------------------------------------------------------
 *  [SHOW COPY NOTIFICATION] - Display centered tooltip notification
 *  @notes: Reusable function to show "Copied!" notification
 * -------------------------------------------------------------------------------------------------*/
function NXShowCopyNotification() {
    //create tooltip element
    var $tooltip = $('<div></div>');
    $tooltip.text(NXLANG.copied);
    $tooltip.css({
        'position': 'fixed',
        'top': '50%',
        'left': '50%',
        'transform': 'translate(-50%, -50%)',
        'background': '#28a745',
        'color': 'white',
        'padding': '8px 16px',
        'border-radius': '4px',
        'z-index': '9999',
        'font-size': '14px',
        'box-shadow': '0 2px 8px rgba(0,0,0,0.2)'
    });

    //add to document
    $('body').append($tooltip);

    //remove after 2 seconds
    setTimeout(function() {
        $tooltip.remove();
    }, 2000);
}

/** --------------------------------------------------------------------------------------------------
 * PRODUCT CUSTOM FIELDS - Show More Button
 * - Shows hidden custom field rows (6-10)
 * - Hides the "show more" button after click
 * --------------------------------------------------------------------------------------------------*/
$(document).on('click', '#show-more-custom-fields', function(e) {
    e.preventDefault();

    // Show hidden rows
    $('#custom-fields-hidden-rows').removeClass('hidden');

    // Hide the button
    $(this).closest('.show-more-button').hide();
});

/** --------------------------------------------------------------------------------------------------
 * NEW USER TICKET TOGGLE
 * - Toggle between client mode and new user mode when creating tickets
 * - New user mode allows creating tickets for email addresses not in the system
 * --------------------------------------------------------------------------------------------------*/
$(document).on("click", "#ticket_type_toggle_email", function (e) {
    e.preventDefault();

    // Set mode
    $("#ticket_type").val("email");

    // Toggle active class
    $(".ticket-type-toggle").removeClass("active");
    $(this).addClass("active");

    // Show new user fields (name + email), hide client and project
    $("#ticket_client_container").hide();
    $("#ticket_email_container").show();
    $("#ticket_project_container").hide();

    // Clear client selection (Select2 compatible)
    $("#ticket_clientid").val('').trigger('change');
    $("#ticket_projectid").val('').trigger('change');
});

$(document).on("click", "#ticket_type_toggle_client", function (e) {
    e.preventDefault();

    // Set mode
    $("#ticket_type").val("client");

    // Toggle active class
    $(".ticket-type-toggle").removeClass("active");
    $(this).addClass("active");

    // Show client and project, hide new user fields
    $("#ticket_client_container").show();
    $("#ticket_email_container").hide();
    $("#ticket_project_container").show();

    // Clear new user fields
    $("#user_name").val("");
    $("#ticket_email").val("");
});