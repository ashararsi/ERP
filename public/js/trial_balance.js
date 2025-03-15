/**
 * Created by mustafa.mughal on 12/7/2017.
 */

//== Class definition
var FormControls = function () {
    //== Private functions

    var baseFunction = function () {
        // To make Pace works on Ajax calls
        $(document).ajaxStart(function () {
            Pace.restart();
        });

        // $('.select2').select2();

        /* $('#account_type_id').select2().on("select2:select", function(e) {
             if($(this).val() != '') {
                 $('#load_report').html('<i class="fa fa-spin fa-refresh"></i>&nbsp;Load Report').attr('disabled',true);
             } else {
                 $('#load_report').html('Load Report').removeAttr('disabled');
             }
             $.ajax({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 url: route('admin.account_reports.load_groups'),
                 type: "POST",
                 data: {
                     account_type_id: $('#account_type_id').val(),
                 },
                 success: function(response){
                     var dropdown = '<select name="group_id" id="group_id" class="form-control select2" style="width: 100%;"> <option value=""> Select a Parent Group </option>' + response.dropdown + '</select>';
                     $('#group_id_content').html(dropdown);
                     $('#group_id').select2();
                     $('#load_report').html('Load Report').removeAttr('disabled');
                 },
                 error: function (xhr, ajaxOptions, thrownError) {
                     $('#load_report').html('Load Report').removeAttr('disabled');
                     return false;
                 }
             });
         });
         */
        var this_financial_year_start, this_financial_year_end, last_financial_year_start, last_financial_year_end;

        if (moment() > moment().startOf('year').month(5).date(30)) {

            this_financial_year_start = moment().startOf('year').month(6).date(1);
            this_financial_year_end = moment().add(1, 'year').startOf('year').month(5).date(30);

            last_financial_year_start = moment().subtract(1, 'year').startOf('year').month(6).date(1);
            last_financial_year_end = moment().startOf('year').month(5).date(30);
        } else {

            this_financial_year_start = moment().subtract(1, 'year').startOf('year').month(6).date(1);
            this_financial_year_end = moment().startOf('year').month(5).date(30);

            last_financial_year_start = moment().subtract(2, 'year').startOf('year').month(6).date(1);
            last_financial_year_end = moment().subtract(1, 'year').startOf('year').month(5).date(30);
        }

        $('#date_range').daterangepicker({
            "alwaysShowCalendars": true,
            locale: {
                format: 'DD/MM/YYYY',
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Fin Year': [this_financial_year_start, this_financial_year_end],
                'Last Fin Year': [last_financial_year_start, last_financial_year_end],
            },
            startDate: this_financial_year_start,
            endDate: this_financial_year_end,
        });


        $('#date_range').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });
    }


    var loadReport = function () {


    }

    var printReport = function (medium_type) {
        $('#date_range-report').val($('#date_range').val());
        $('#branch_id-report').val($('#branch_id').val());
        $('#company_id-report').val($('#company_id').val());
        //    $('#employee_id-report').val($('#employee_id').val());
        //    $('#department_id-report').val($('#department_id').val());
        //    $('#entry_type_id-report').val($('#entry_type_id').val());
        $('#group_id-report').val($('#group_id').val());
        $('#medium_type-report').val(medium_type);
        $('#view_as-report').val($('#view_as').val());
        $('#report-form').submit();
    }

    return {
        // public functions
        init: function () {
            baseFunction();
        },
        loadReport: loadReport,
        printReport: printReport,
    };
}();

jQuery(document).ready(function () {
    FormControls.init();
});
