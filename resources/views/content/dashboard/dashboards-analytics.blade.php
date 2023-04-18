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
                                value="{{ $info->sourcefolder }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Đường dẫn Thư mục xuất file</label>
                            <input name="exportfolder" type="text" class="form-control" required
                                value="{{ $info->exportfolder }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Tên thư mục xuất file</label>
                            <input name="exportname" style="max-width:250px" type="text" class="form-control"
                                id="exampleFormControlInput1" required value="{{ $info->exportname }}">
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
                        <h5 class="mb-0">Thông báo</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-12 col-lg-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Support Tracker -->

        <!-- Sales By Country -->
        <div class="col-xl-8 col-md-6 mb-4">
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

        <!-- Total Earning -->
        <div class="col-12 col-xl-4 mb-4 col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-1">
                    <h5 class="mb-0 card-title">Total Earning</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="totalEarning" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalEarning">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h1 class="mb-0 me-2">87%</h1>
                        <i class="ti ti-chevron-up text-success me-1"></i>
                        <p class="text-success mb-0">25.8%</p>
                    </div>
                    <div id="totalEarningChart"></div>
                    <div class="d-flex align-items-start my-4">
                        <div class="badge rounded bg-label-primary p-2 me-3 rounded"><i
                                class="ti ti-currency-dollar ti-sm"></i></div>
                        <div class="d-flex justify-content-between w-100 gap-2 align-items-center">
                            <div class="me-2">
                                <h6 class="mb-0">Total Sales</h6>
                                <small class="text-muted">Refund</small>
                            </div>
                            <p class="mb-0 text-success">+$98</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="badge rounded bg-label-secondary p-2 me-3 rounded"><i
                                class="ti ti-brand-paypal ti-sm"></i></div>
                        <div class="d-flex justify-content-between w-100 gap-2 align-items-center">
                            <div class="me-2">
                                <h6 class="mb-0">Total Revenue</h6>
                                <small class="text-muted">Client Payment</small>
                            </div>
                            <p class="mb-0 text-success">+$126</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Total Earning -->

        <!-- Monthly Campaign State -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Monthly Campaign State</h5>
                        <small class="text-muted">8.52k Social Visiters</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="MonthlyCampaign" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="MonthlyCampaign">
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Download</a>
                            <a class="dropdown-item" href="javascript:void(0);">View All</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="mb-4 pb-1 d-flex justify-content-between align-items-center">
                            <div class="badge bg-label-success rounded p-2"><i class="ti ti-mail ti-sm"></i></div>
                            <div class="d-flex justify-content-between w-100 flex-wrap">
                                <h6 class="mb-0 ms-3">Emails</h6>
                                <div class="d-flex">
                                    <p class="mb-0 fw-semibold">12,346</p>
                                    <p class="ms-3 text-success mb-0">0.3%</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-4 pb-1 d-flex justify-content-between align-items-center">
                            <div class="badge bg-label-info rounded p-2"><i class="ti ti-link ti-sm"></i></div>
                            <div class="d-flex justify-content-between w-100 flex-wrap">
                                <h6 class="mb-0 ms-3">Opened</h6>
                                <div class="d-flex">
                                    <p class="mb-0 fw-semibold">8,734</p>
                                    <p class="ms-3 text-success mb-0">2.1%</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-4 pb-1 d-flex justify-content-between align-items-center">
                            <div class="badge bg-label-warning rounded p-2"><i class="ti ti-click ti-sm"></i></div>
                            <div class="d-flex justify-content-between w-100 flex-wrap">
                                <h6 class="mb-0 ms-3">Clicked</h6>
                                <div class="d-flex">
                                    <p class="mb-0 fw-semibold">967</p>
                                    <p class="ms-3 text-success mb-0">1.4%</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-4 pb-1 d-flex justify-content-between align-items-center">
                            <div class="badge bg-label-primary rounded p-2"><i class="ti ti-users ti-sm"></i></div>
                            <div class="d-flex justify-content-between w-100 flex-wrap">
                                <h6 class="mb-0 ms-3">Subscribe</h6>
                                <div class="d-flex">
                                    <p class="mb-0 fw-semibold">345</p>
                                    <p class="ms-3 text-success mb-0">8.5k</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-4 pb-1 d-flex justify-content-between align-items-center">
                            <div class="badge bg-label-secondary rounded p-2"><i
                                    class="ti ti-alert-triangle ti-sm text-body"></i></div>
                            <div class="d-flex justify-content-between w-100 flex-wrap">
                                <h6 class="mb-0 ms-3">Complaints</h6>
                                <div class="d-flex">
                                    <p class="mb-0 fw-semibold">10</p>
                                    <p class="ms-3 text-success mb-0">1.5%</p>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <div class="badge bg-label-danger rounded p-2"><i class="ti ti-ban ti-sm"></i></div>
                            <div class="d-flex justify-content-between w-100 flex-wrap">
                                <h6 class="mb-0 ms-3">Unsubscribe</h6>
                                <div class="d-flex">
                                    <p class="mb-0 fw-semibold">86</p>
                                    <p class="ms-3 text-success mb-0">0.8%</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Monthly Campaign State -->

        <!-- Source Visit -->
        <div class="col-xl-4 col-md-6 order-2 order-lg-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Source Visits</h5>
                        <small class="text-muted">38.4k Visitors</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="sourceVisits" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sourceVisits">
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Download</a>
                            <a class="dropdown-item" href="javascript:void(0);">View All</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 pb-1">
                            <div class="d-flex align-items-start">
                                <div class="badge bg-label-secondary p-2 me-3 rounded"><i class="ti ti-shadow ti-sm"></i>
                                </div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Direct Source</h6>
                                        <small class="text-muted">Direct link click</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">1.2k</p>
                                        <div class="ms-3 badge bg-label-success">+4.2%</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3 pb-1">
                            <div class="d-flex align-items-start">
                                <div class="badge bg-label-secondary p-2 me-3 rounded"><i class="ti ti-globe ti-sm"></i>
                                </div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Social Network</h6>
                                        <small class="text-muted">Social Channels</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">31.5k</p>
                                        <div class="ms-3 badge bg-label-success">+8.2%</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3 pb-1">
                            <div class="d-flex align-items-start">
                                <div class="badge bg-label-secondary p-2 me-3 rounded"><i class="ti ti-mail ti-sm"></i>
                                </div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Email Newsletter</h6>
                                        <small class="text-muted">Mail Campaigns</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">893</p>
                                        <div class="ms-3 badge bg-label-success">+2.4%</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3 pb-1">
                            <div class="d-flex align-items-start">
                                <div class="badge bg-label-secondary p-2 me-3 rounded"><i
                                        class="ti ti-external-link ti-sm"></i></div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Referrals</h6>
                                        <small class="text-muted">Impact Radius Visits</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">342</p>
                                        <div class="ms-3 badge bg-label-danger">-0.4%</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3 pb-1">
                            <div class="d-flex align-items-start">
                                <div class="badge bg-label-secondary p-2 me-3 rounded"><i
                                        class="ti ti-discount-2 ti-sm"></i></div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">ADVT</h6>
                                        <small class="text-muted">Google ADVT</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">2.15k</p>
                                        <div class="ms-3 badge bg-label-success">+9.1%</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="d-flex align-items-start">
                                <div class="badge bg-label-secondary p-2 me-3 rounded"><i class="ti ti-star ti-sm"></i>
                                </div>
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Other</h6>
                                        <small class="text-muted">Many Sources</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">12.5k</p>
                                        <div class="ms-3 badge bg-label-success">+6.2%</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Source Visit -->
    </div>

@endsection
