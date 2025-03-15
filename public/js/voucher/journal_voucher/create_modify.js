/**
 * Created by mustafa.mughal on 12/7/2017.
 */

//== Class definition

var FormControls = function () {
    //== Private functions

    var baseFunction = function () {

        $('.description-data-ajax').select2(Select2AjaxObj());
        $('#entry_item-vendor_id-1').select2();
        // $(".datepicker").datepicker({format: 'yyyy-mm-dd'});

        // $('#branch_id').select2();
        // $('#entry_type_id').select2();
        $('#employee_id').select2();

        // $("#validation-form").validate({
        //     // define validation rules
        //     errorElement: 'span',
        //     errorClass: 'help-block',
        //     rules: {
        //         number: {
        //             required: true
        //         },
        //         voucher_date: {
        //             required: true,
        //         },
        //         branch_id: {
        //             required: true
        //         },
        //         employee_id: {
        //             required: true
        //         },
        //         narration: {
        //             required: true
        //         },
        //         dr_total: {
        //             required: true,
        //             number: true,
        //             min: 1,
        //             equalTo: '#cr_total',
        //         },
        //         cr_total: {
        //             required: true,
        //             number: true,
        //             min: 1,
        //             equalTo: '#dr_total',
        //         },
        //         diff_total: {
        //             required: true,
        //             number: true,
        //             min: 0,
        //             max: 0,
        //         },
        //     },
        //     messages: {
        //         dr_total: {
        //             required: "Field is require.",
        //             number: "Field is require.",
        //             min: "All Items Debit should greater than zero.",
        //             equalTo: 'Debit must equal to Credit amount.',
        //         },
        //         cr_total: {
        //             required: "Field is require.",
        //             number: "Field is require.",
        //             min: "All Items Credit should greater than zero.",
        //             equalTo: 'Credit must equal to Debit amount.',
        //         },
        //         diff_total: {
        //             required: "Field is require.",
        //             number: "Field is require.",
        //             min: "Difference of Debit and Credit should zero.",
        //             max: "Difference of Debit and Credit should zero.",
        //         },
        //     },
        //     highlight: function (element) { // hightlight error inputs
        //         $(element)
        //             .closest('.form-group').addClass('has-error'); // set error class to the control group
        //     },
        //     errorPlacement: function (error, element) {
        //         if (element.attr("name") == "branch_id") {
        //             error.insertAfter($('#branch_id_handler'));
        //         } else if (element.attr("name") == "employee_id") {
        //             error.insertAfter($('#employee_id_handler'));
        //         } else if (element.attr("name") == "entry_items[ledger_id][]") {
        //             error.insertAfter(element.parent());
        //         } else {
        //             error.insertAfter(element);
        //         }
        //     },
        //     success: function (label) {
        //         label.closest('.form-group').removeClass('has-error');
        //         label.remove();
        //     }
        // });

        CalculateTotal();
    }

    var Select2AjaxObj = function () {

        return {
            allowClear: true,
            placeholder: "Account",
            minimumInputLength: 2,
            ajax: {
                url: '/admin/gjv_search',
                dataType: 'json',
                delay: 500,
                data: function (params) {
                    return {
                        item: params.term, company_id: $("#company_id").val(), branch_id: $("#branch_id").val(),
                    };
                },
                processResults: function (data) {
                    console.log(data);
                    if (data.status == 1) {
                        return {
                            results: data.data
                        };
                    } else {
                        alert('Select Branch');
                    }

                },
            }
        }
    }

    var CalculateTotal = function () {

        var total_dr_amount = 0;
        var total_cr_amount = 0;

        $('.entry_items-dr_amount').each(function (index) {

            var target_cr = $(this).attr('id').replace("entry_item-dr_amount-", "");
            if ($(this).val() != '' && $(this).val() != '0') {
                total_dr_amount = total_dr_amount + parseFloat($(this).val());
                $('#entry_item-cr_amount-' + target_cr).attr('readonly', true);
                $('#entry_item-cr_amount-' + target_cr).val('0');
            } else {
                $('#entry_item-cr_amount-' + target_cr).removeAttr('readonly');
                if ($(this).val() == '' && $('#entry_item-cr_amount-' + target_cr).val() == '0') {
                    $('#entry_item-cr_amount-' + target_cr).val('');
                }
            }
        });

        $('.entry_items-cr_amount').each(function (index) {
            var target_dr = $(this).attr('id').replace("entry_item-cr_amount-", "");
            if ($(this).val() != '' && $(this).val() != '0') {
                total_cr_amount = total_cr_amount + parseFloat($(this).val());
                $('#entry_item-dr_amount-' + target_dr).attr('readonly', true);
                $('#entry_item-dr_amount-' + target_dr).val('0');
            } else {
                $('#entry_item-dr_amount-' + target_dr).removeAttr('readonly');
                if ($(this).val() == '' && $('#entry_item-dr_amount-' + target_dr).val() == '0') {
                    $('#entry_item-dr_amount-' + target_dr).val('');
                }
            }
        });

        $('#dr_total').val(total_dr_amount);
        $('#cr_total').val(total_cr_amount);
        $('#diff_total').val(total_dr_amount - total_cr_amount);

        // var global_counter = $('#entry_item-global_counter').val();
        // if (global_counter == 1) {
        //     updateNarration();
        // }
    }

    var createEntryItem = function () {
        var global_counter = parseInt($('#entry_item-global_counter').val()) + 1;
        var entry_item = $('#entry_item-container').html().replace(/########/g, '').replace(/######/g, global_counter);
        $('#entry_items tr:last').before(entry_item);
        // Apply Select2 on newly created item
        $('#entry_item-ledger_id-' + global_counter).select2(Select2AjaxObj());
        $('#entry_item-vendor_id-' + global_counter).select2();
        $('#entry_item-global_counter').val(global_counter);
        updateNarration(global_counter);
    }

    var destroyEntryItem = function (itemId) {
        var r = confirm("Are you sure to delete Entry Item?");
        if (r == true) {
            $('#entry_item-ledger_id-' + itemId).select2(Select2AjaxObj());
            $('#entry_item-vendor_id-' + itemId).select2();
            $('.entry_item-' + itemId).remove();
            CalculateTotal();
        }
    }

    var updateNarration = function (global_counter) {
        if (global_counter == undefined) {
            $('.entry_items-narration').each(function (index) {
                if ($('#narration').val() != '') {
                    $(this).val($('#narration').val());
                }
            });
        } else {
            $('#entry_item-narration-' + global_counter).val($('#narration').val());
        }
    }

    var checkInstrumentNo = function (global_counter) {
        var instrumentNo = $('#entry_item-instrument_number-' + global_counter).val();
        $.ajax({
            url: '/admin/check-instrument-no',
            type: "GET",
            data: {
                'instrumentNo': instrumentNo,
            },
            success: function (status) {
                if (status == 1) {
                    alert('Instrument number exists!');
                    // $('#entry_item-instrument_number-' + global_counter).val('');
                    // $('#entry_item-instrument_number-' + global_counter).focus();
                    // return false;
                }
            },
            error: function (error) {
                console.log('error ' + error);
            }
        });

    }

    return {
        // public functions
        init: function () {
            baseFunction();
        },
        createEntryItem: createEntryItem,
        destroyEntryItem: destroyEntryItem,
        CalculateTotal: CalculateTotal,
        updateNarration: updateNarration,
        checkInstrumentNo: checkInstrumentNo
    };
}();

jQuery(document).ready(function () {
    FormControls.init();


    function getVoucherNo() {
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/admin/getVoucherNo",
            data: {
                'financial_year_id': $('.financial_year').val(),
                'company_id': $('#company_id').val(),
                'entry_type_id': $('#entry_type_id').val()
            },
            beforeSend: function () {
                showLoader();
            },
            success: function (data) {
                $('#number').val(data);
            }, complete: function () {
                hideLoader();
            }
        });
    }

    $('.financial_year').change(function () {

        var selectedOption = $(this).find('option:selected');
        var startDate = selectedOption.data('start_date');
        var endDate = selectedOption.data('end_date');

        console.log(startDate + ' / ' + endDate);

        if (startDate != '' && endDate != '') {
            $(".daterange").datepicker("destroy").datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: new Date(startDate),
                maxDate: new Date(endDate)
            });
        } else {
            $(".daterange").datepicker("destroy");
        }

        getVoucherNo();

    });

    $('.financial_year').trigger('change');

});
