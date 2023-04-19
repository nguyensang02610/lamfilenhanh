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
            if (i === 3) { // nếu là cột cuối cùng thì bỏ qua
                return;
            }
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
                url: baseUrl + 'api/storage/' + user_id,
            },
            columns: [
                { data: 'ma_hinh' },
                { data: 'dong_may' },
                { data: 'note' },
                { data: 'action' },
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Action',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, full, meta) {
                        var id = full.id;
                        return '<a href="javascript:;" class="btn btn-sm btn-icon item-edit" data-id="' + id + '"><i class="text-primary ti ti-pencil"></i></a>' +
                            '<a href="javascript:;" class="btn btn-sm btn-icon delete" data-id="' + id + '"><i class="text-danger ti ti-trash"></i></a>';
                    }
                }
            ],
            orderCellsTop: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
        });
    }

    // Advanced Search
    // --------------------------------------------------------------------
    // sự kiện click nút xóa
    $('.dt-column-search').on('click', '.delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa bản ghi?',
            text: 'Bạn không thể khôi phục bản ghi sau khi xóa!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa!',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl + 'kho-delete/' + id,
                    type: 'DELETE',
                    success: function (data) {
                        dt_filter.ajax.reload();
                        Swal.fire(
                            'Đã xóa!',
                            'Bản ghi đã được xóa thành công.',
                            'success'
                        );
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        Swal.fire(
                            'Lỗi!',
                            'Không thể xóa bản ghi. Vui lòng thử lại sau.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $(document).on('click', '.item-edit', function () {
        // Lấy dữ liệu từ dòng đó
        var row = $(this).closest('tr');
        var ma_hinh = row.find('td:eq(0)').text();
        var dong_may = row.find('td:eq(1)').text();
        var note = row.find('td:eq(2)').text();

        // Đổ dữ liệu vào các input của modals
        $('#modalCenter1').find('input[name="ma_hinh"]').val(ma_hinh);
        $('#modalCenter1').find('input[name="dong_may"]').val(dong_may);
        $('#modalCenter1').find('input[name="note"]').val(note);

        // Hiển thị modals
        $('#modalCenter1').modal('show');
    });

    //Sửa bản ghi
    // Khi người dùng nhấn nút "Lưu" trong modal
    $('#modalCenter1 form').submit(function (event) {
        // Ngăn chặn hành động mặc định của form (submit)
        event.preventDefault();

        // Lấy giá trị từ các ô input
        var maHinh = $('#modalCenter1 input[name="ma_hinh"]').val();
        var dongMay = $('#modalCenter1 input[name="dong_may"]').val();
        var note = $('#modalCenter1 input[name="note"]').val();

        // Lấy ID của bản ghi để cập nhật
        var recordId = $('#modalCenter1').data('record-id');

        // Gửi AJAX request để cập nhật bản ghi
        $.ajax({
            url: '/kho/' + recordId,
            type: 'PUT',
            data: {
                ma_hinh: maHinh,
                dong_may: dongMay,
                note: note
            },
            success: function (response) {
                // Nếu request thành công, hiển thị sweetalert thông báo
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật bản ghi thành công',
                    showConfirmButton: false,
                    timer: 1500
                });

                // Ẩn modal
                $('#modalCenter1').removeClass('show');
                $('.modal-backdrop').remove();

                // Tải lại trang để hiển thị bản ghi mới cập nhật
                location.reload();
            },
            error: function (xhr) {
                // Nếu request thất bại, hiển thị sweetalert thông báo lỗi
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Có lỗi xảy ra khi cập nhật bản ghi',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });




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
