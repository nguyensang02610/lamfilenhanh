@extends('layouts/layoutMaster')

@section('title', 'Analytics')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" /> --}}
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@endsection

@include('sweetalert::alert')

@section('content')
    <?php
    // dd($info);
    ?>
    <div class="row">
        <!-- Earning Reports -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <form method="post" action="{{ route('info-save') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Đường dẫn Thư mục hình gốc</label>
                            <input name="sourcefolder" type="text" class="form-control" required
                                value="{{ optional($info)->sourcefolder }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Đường dẫn Thư mục xuất file</label>
                            <input name="exportfolder" type="text" class="form-control" required
                                value="{{ optional($info)->exportfolder }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Tên thư mục xuất file</label>
                            <input name="exportname" style="max-width:250px" type="text" class="form-control"
                                id="exampleFormControlInput1" required value="{{ optional($info)->exportname }}">
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light btn-save">
                            <span class="ti-xs ti ti-star me-1"></span>Lưu
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!--/ Earning Reports -->

        <!-- Support Tracker -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Thông tin tài khoản</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="fw-semibold me-1">Username:</span>
                                <span>violet.dev</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Email:</span>
                                <span>vafgot@vultukir.org</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Status:</span>
                                <span class="badge bg-label-success">Active</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Role:</span>
                                <span>Author</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Tax id:</span>
                                <span>Tax-8965</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser"
                                data-bs-toggle="modal">Edit</a>
                            <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspended</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Support Tracker -->

        <!-- Sales By Country -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Làm file</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                                    aria-selected="true"><i class="tf-icons ti ti-home ti-xs me-1"></i> Shopee <span
                                        class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-justified-profile"
                                    aria-controls="navs-pills-justified-profile" aria-selected="false" tabindex="-1"><i
                                        class="tf-icons ti ti-user ti-xs me-1"></i> Sota</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-justified-messages"
                                    aria-controls="navs-pills-justified-messages" aria-selected="false" tabindex="-1"><i
                                        class="tf-icons ti ti-message-dots ti-xs me-1"></i>Facebook</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="navs-pills-justified-home" role="tabpanel">
                                <div class="card-body">
                                    <form method="POST" action="{{ route('excel-upload') }}"
                                        enctype="multipart/form-data" class="dropzone needsclick" id="dropzone-basic">
                                        @csrf
                                        {{-- <input  type="file" multiple /> --}}
                                        <input name="excel[]" class="form-control mb-3" type="file" id="formFile"
                                            multiple accept=".xlsx" placeholder="Chọn file xsls">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light btn-save">
                                            <span class="ti-xs ti ti-star me-1"></span>Làm file
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">

                            </div>

                            <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Sales By Country -->

        <!-- Monthly Campaign State -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Log làm file</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="MonthlyCampaign" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="MonthlyCampaign">
                            <a class="dropdown-item" href="javascript:void(0);">Tải lại</a>
                            <a class="dropdown-item" href="javascript:void(0);">Xem tất cả</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="accordion mt-3" id="accordionExample">
                        @if (count($history) > 0)
                            @foreach ($history as $i => $item)
                                <div class="card mb-3 accordion-item {{ $i === 0 ? ' active' : '' }} ">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#accordion{{ $item->id }}" aria-expanded="true"
                                            aria-controls="accordion{{ $item->id }}">
                                            Log làm file #{{ $item->id }} - vào
                                            {{ $item->created_at->format('H:i - d/m/Y') }}
                                        </button>
                                    </h2>
                                    <div id="accordion{{ $item->id }}"
                                        class="accordion-collapse collapse {{ $i === 0 ? ' show' : '' }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="card-body pb-0">
                                            <ul class="timeline ms-1 mb-0">
                                                @foreach ($item->notifications as $notification)
                                                    <li class="timeline-item timeline-item-transparent">
                                                        <span
                                                            class="timeline-point timeline-point-{{ $notification->zone }}"></span>
                                                        <div class="timeline-event">
                                                            <div class="timeline-header">
                                                                <h6 class="mb-0">{{ $notification->content }}</h6>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                            {{ $history->links('content.panigate.my-panigate') }}</nav>
                        @else
                            <h6 class="text-center">Không có dữ liệu</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--/ Monthly Campaign State -->
    </div>


@endsection
