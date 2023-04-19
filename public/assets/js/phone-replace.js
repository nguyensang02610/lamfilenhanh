/**
 * DataTables Advanced (jquery)
 */

'use strict';

$(function () {
    var dt_filter_table = $('.dt-column-search');

    var user_id = $('.user').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Column Search
    // --------------------------------------------------------------------

    if (dt_filter_table.length) {
        // Setup - add a text input to each footer cell
        $('.dt-column-search thead tr').clone(true).appendTo('.dt-column-search thead');
        $('.dt-column-search thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="form-control" placeholder="Tìm kiếm ' + title + '" />');

            $('input', this).on('keyup change', function () {
                if (dt_filter.column(i).search() !== this.value) {
                    dt_filter.column(i).search(this.value).draw();
                }
            });
        });

        var dt_filter = dt_filter_table.DataTable({
            ajax: {
                url: baseUrl + 'replace-phone/' + user_id,
            },
            columns: [
                { data: 'dong_may' },
                { data: 'dong_may_thay' },
                { data: 'note' },
            ],
            orderCellsTop: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
        });
    }

    // Advanced Search
    // --------------------------------------------------------------------


    // on key up from input field
    $('input.dt-input').on('keyup', function () {
        filterColumn($(this).attr('data-column'), $(this).val());
    });


    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 200);
});
