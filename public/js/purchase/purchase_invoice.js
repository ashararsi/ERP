
var FormControls = function () {
   
    var baseFunction = function () {

        $('.base-data-ajax').select2({
            allowClear: true,
            placeholder: "Select Vendor",
            minimumInputLength: 2,
            ajax: {
                url:'http://127.0.0.1:8000/admin/load-vendor-search',
                dataType: 'json',
                delay: 500,
                data: function (params) {
                    return {
                        name: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        });

        $('.description-data-ajax').select2(Select2AjaxObj());

      //  $(".datepicker").datepicker({ format: 'yyyy-mm-dd' });

    

        $( "#validation-form" ).validate({
            // define validation rules
            errorElement: 'span',
            errorClass: 'help-block',
            rules: {
                number: {
                    required: true
                },
                voucher_date: {
                    required: true,
                },
                branch_id: {
                    required: true
                },
                employee_id: {
                    required: true
                },
                narration: {
                    required: true
                },
                dr_total: {
                    required: true,
                    number: true,
                    min: 1,
                    equalTo: '#cr_total',
                },
                cr_total: {
                    required: true,
                    number: true,
                    min: 1,
                    equalTo: '#dr_total',
                },
                diff_total: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 0,
                },
            },
            messages: {
                dr_total: {
                    required: "Field is require.",
                    number: "Field is require.",
                    min: "All Items Total Amount should greater than zero.",
                    equalTo: 'Cash Total must equal to Total Amount.',
                },
                cr_total: {
                    required: "Field is require.",
                    number: "Field is require.",
                    min: "All Items Total Amount should greater than zero.",
                    equalTo: 'Total Amount must equal to Cash Total.',
                },
                diff_total: {
                    required: "Field is require.",
                    number: "Field is require.",
                    min: "Difference of Cash and Total should zero.",
                    max: "Difference of Cash and Total should zero.",
                },
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            errorPlacement: function (error, element) {
            
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            }
        });

        CalculateTotal();
    }

    var Select2AjaxObj = function () {
        return {
            allowClear: true,
            placeholder: "Select Product",
            minimumInputLength: 2,
            ajax: {
                url: 'http://127.0.0.1:8000/admin/load-products-search',
                dataType: 'json',
                delay: 500,
                data: function (params) {
                    return {
                        item: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        }
    }
    
    var CalculateTotal = function () {
        var total_cr_amount = 0;

        $('.entry_items-dr_amount').each(function (index) {
            var target_cr = $(this).attr('id').replace("entry_item-dr_amount-", "");
            if($(this).val() != '' && $(this).val() != '0') {
                var quantity = parseFloat( $('#entry_item-cr_amount-'+target_cr).val());
               var each_price =  parseFloat($(this).val());
                    var total = quantity * each_price;
                total_cr_amount = total_cr_amount+total;
            }
            $('#entry_item-narration-'+target_cr).val(total);
        });

   
     

        $('#cr_total').val(total_cr_amount);
    }

    var createEntryItem = function () {
        var global_counter = parseInt($('#entry_item-global_counter').val()) + 1;
        var entry_item = $('#entry_item-container').html().replace(/########/g, '').replace(/######/g, global_counter);
        $('#entry_items tr:last').before(entry_item);
        // Apply Select2 on newly created item
        $('#entry_item-ledger_id-'+global_counter).select2(Select2AjaxObj());
        $('#entry_item-global_counter').val(global_counter)
    }

    var destroyEntryItem = function (itemId) {
        var r = confirm("Are you sure to delete Entry Item?");
        if (r == true) {
            $('#entry_item-ledger_id-'+itemId).select2(Select2AjaxObj());
            $('#entry_item-'+itemId).remove();
            CalculateTotal();
        }
    }



    return {
        // public functions
        init: function() {
            baseFunction();
        },
        createEntryItem: createEntryItem,
        destroyEntryItem: destroyEntryItem,
        CalculateTotal: CalculateTotal
    };
}();

jQuery(document).ready(function() {
    FormControls.init();
});