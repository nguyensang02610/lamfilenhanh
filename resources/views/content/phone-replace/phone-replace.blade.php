@extends('layouts/layoutMaster')

@section('title', 'DataTables - Advanced Tables')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('assets/js/phone-replace.js') }}"></script>
@endsection

<?php
// dd($user_id);
?>
@section('content')

    <h4 class="fw-bold py-3 mb-1">
        <span class="text-muted fw-light">Thêm dòng máy thay thế khi làm file ( ex : ip 7 / 8 plus => ip 7 plus)
    </h4>
    {{-- <button type="button" class="btn btn-primary mb-3">
        <span class="ti-xs ti ti-plus me-1"></span>Thêm kho
    </button> --}}
    <div class="mb-3">
        <button style="margin-right:20px" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#basicModal">
            <span class="ti-xs ti ti-plus me-1"></span>Thêm dòng máy thủ công
        </button>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
            <span class="ti-xs ti ti-plus me-1"></span>Thêm hàng loạt excel
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="/replace-phone">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Thêm dòng máy thay thế</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="emailBasic" class="form-label">Tên ban đầu của shop ( ex : ip 7 / 8
                                    plus)</label>
                                <input name="dong_may" type="text" id="emailBasic" class="form-control">
                            </div>
                            <div class="col mb-0">
                                <label for="dobBasic" class="form-label">Tên máy đc thay thế (ex : ip 7 plus) </label>
                                <input name="dong_may_thay" type="text" id="dobBasic" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Ghi chú</label>
                                <input name="note" type="text" id="nameBasic" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tải lên file excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('phone-excel') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Name</label>
                                <input name="excelfile" type="file" accept=".xlsx" id="nameWithTitle"
                                    class="form-control">
                            </div>
                            <a href="/download-phone"><button type="button" class="btn btn-outline-success">Tải file excel
                                    thay thế máy mẫu</button></a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Tải lên</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" name="user_id" value="{{ $user_id }}" class="user">

    <!-- Column Search -->
    <div class="card">

        <div class="card-datatable text-nowrap">

            <table class="dt-column-search table">
                <thead>
                    <tr>
                        <th>Dòng máy</th>
                        <th>Dòng máy thay thế</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Column Search -->


@endsection
