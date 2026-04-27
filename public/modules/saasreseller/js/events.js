"use strict";

$(document).ready(function () {

    /** --------------------------------------------------------------------------------------------------
     * Load events timeline
     * -------------------------------------------------------------------------------------------------*/
    if ($("#dynamic-load-timeline-events").length) {
        nxAjaxUxRequest($("#dynamic-load-timeline-events"));
    }

    /** --------------------------------------------------------------------------------------------------
     *  start process to mark payout as completed
     * -------------------------------------------------------------------------------------------------*/
    $(document).on("click", "#reseller-payout-first-step-button", function (e) {
        $("#reseller-payout-first-step-wrapper").hide();
        $("#reseller-payout-payment-options-wrapper").show();
    });


    /** --------------------------------------------------------------------------------------------------
     * RESELLER PAYOUT DETAILS - Toggle Payment Method Sections
     * - Shows/hides PayPal or Wire Transfer sections based on selected payout method
     * - Triggers on page load and when dropdown value changes
     * --------------------------------------------------------------------------------------------------*/
    //on page load, show the correct section
    $(document).on('shown.bs.modal', '#commonModal', function () {
        if ($('#mod_saasreseller_reseller_payout_method').length) {
            NXSaaSResellerTogglePayoutMethod();
        }
    });

    //on dropdown change
    $(document).on("select2:select", "#mod_saasreseller_reseller_payout_method", function (e) {
        NXSaaSResellerTogglePayoutMethod();
    });

    //on page load for reseller payout method page (not modal)
    if ($('#mod_saasreseller_reseller_payout_method').length && $('#payout-method-form-wrapper').length) {
        setTimeout(function() {
            NXSaaSResellerTogglePayoutMethod();
        }, 500);
    }

    //reseller tab clicked
    $(document).on('click', '.reseller-menu-tab', function () {
        $('.reseller-menu-tab').removeClass('active');
        $(this).addClass('active');

    })

    /** --------------------------------------------------------------------------------------------------
     * RESELLER PAYOUT - Toggle PayPal/Bank Forms
     * - Shows/hides PayPal or Bank forms based on selected radio button
     * --------------------------------------------------------------------------------------------------*/
    $(document).on('change', 'input[name="payout_method_display"]', function () {
        NXSaaSResellerTogglePayoutForm();
    });


    /**
     * Commission Modal: Reseller select change
     * Auto-fill commission rate from reseller's default rate
     */
    $(document).on('select2:select', '#mod_saasreseller_commission_reseller_id', function (e) {
        var selected = $(this).find(':selected');
        var commission_rate = selected.data('reseller-commission');
        if (commission_rate) {
            $('#mod_saasreseller_commission_commission_rate').val(commission_rate);
        }
    });

    /**
     * Commission Modal: Customer select change
     * Load unallocated payments for selected customer
     */
    $(document).on('select2:select', '#mod_saasreseller_commission_tenant_id', function (e) {
        NXSaaSResellerCustomerAndPaymentsToggle(e, $(this));
    });


});


/**--------------------------------------------------------------------------------------
 * [set menu active]
 * app > saasreseller > fooo
 * -------------------------------------------------------------------------------------*/
window.addEventListener('load', function () {
    if ($("#module_saasreseller_menu_main").length) {
        $("#module_saasreseller_menu_main").trigger('click');
        $("#module_saasreseller_fooos").addClass('active');
    }
});


/**--------------------------------------------------------------------------------------
 * RESELLER PAYOUT DETAILS - Toggle Payment Method Sections
 * Shows or hides PayPal/Wire Transfer sections based on dropdown
 * -------------------------------------------------------------------------------------*/
function NXSaaSResellerTogglePayoutMethod() {
    //get selected value
    var selected_method = $('#mod_saasreseller_reseller_payout_method').val();

    //hide both sections first
    $('#payout_method_paypal_section').hide();
    $('#payout_method_wire_section').hide();

    //show the correct section
    if (selected_method == 'paypal') {
        $('#payout_method_paypal_section').show();
    } else if (selected_method == 'wire') {
        $('#payout_method_wire_section').show();
    } else {
        //default to paypal if no value selected
        $('#payout_method_paypal_section').show();
    }
}


/**--------------------------------------------------------------------------------------
 * RESELLER PAYOUT - Toggle PayPal/Bank Forms
 * Shows or hides PayPal/Bank forms based on selected radio button
 * -------------------------------------------------------------------------------------*/
function NXSaaSResellerTogglePayoutForm() {
    //get selected value
    var selected_method = $('input[name="payout_method_display"]:checked').val();

    //hide both forms first
    $('#reseller-payouts-form-paypal').hide();
    $('#reseller-payouts-form-bank').hide();

    //make section visible
    $("#reseller-payout-payment-forms-wrapper").show();

    //show the correct form
    if (selected_method == 'paypal') {
        $('#reseller-payouts-form-paypal').show();
    } else if (selected_method == 'bank') {
        $('#reseller-payouts-form-bank').show();
    }
}


/**--------------------------------------------------------------------------------------
 * Initialize email templates editor
 * -------------------------------------------------------------------------------------*/
function NXSaaSResellerEmailTemplates() {
    //show hidden containers
    $("#email-templates-editing-container").removeClass('hidden');
    $("#emailEditContainer").removeClass('hidden');

    nxTinyMCEAdvanced(500, '#emailtemplate_body', 'fullpage spellchecker', '');
    setTimeout(function () {
        $("#email-templates-editing").removeClass('loading');
        $("#email-templates-editing-container").show();
        $("#emailEditContainer").show();
        $("#emailEditWrapper").removeClass('loading');
    }, 1000);


    //fix for validator
    $("#fix-form-email-templates").validate({});
};


/**--------------------------------------------------------------------------------------
 * Load unallocated payments for selected customer
 * -------------------------------------------------------------------------------------*/
function NXSaaSResellerCustomerAndPaymentsToggle(e, $self) {

    //get the customer id
    var tenant_id = e.params.data.id;

    //get the payments container
    var payments_container = $('#' + $self.attr('data-loading-target'));

    //clear container and show loading
    payments_container.html('<div class="text-muted p-t-10"><i class="ti-reload"></i> Loading...</div>');

    //make ajax call to get unallocated payments
    $.ajax({
        type: 'GET',
        url: $self.attr('data-payments-url') + '?tenant_id=' + tenant_id
    }).then(function (response) {
        //update the container with the response html
        if (response.dom_html) {
            for (var i = 0; i < response.dom_html.length; i++) {
                var item = response.dom_html[i];
                $(item.selector).html(item.value);
            }
        }
    });
}