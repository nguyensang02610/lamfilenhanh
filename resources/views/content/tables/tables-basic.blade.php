@extends('layouts/layoutMaster')

@section('title', 'Kho và tồn hàng')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Bảng tồn kho</span>
    </h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Danh sách hàng tồn</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã hình</th>
                        <th>Dòng máy</th>
                        <th>Ghi chú</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($infos as $item)
                        <tr>
                            <td>{{ $item->ma_hinh }}</td>

                            <td>{{ $item->dong_may }}</td>

                            <td>{{ $item->note }}</td>

                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-pencil me-1"></i>
                                            Sửa</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-trash me-1"></i>
                                            Xóa</a>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->



@endsection
