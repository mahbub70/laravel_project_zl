@extends('layouts.app')

{{-- Title --}}
@section('title')
    <title>Admin Home - Zaman's Laptop</title>
@endsection

@section('content')
<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row g-3">
            <div class="col-lg-12 col-md-12">
                <div class="tab-content mt-1">
                    <div class="tab-pane fade show active" id="summery-today">
                        <div class="row g-1 g-sm-3 mb-3 row-deck">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="left-info">
                                            <span class="text-muted">Total Products</span>
                                            <div><span class="fs-6 fw-bold me-2">{{ count(App\Models\Product::all()) }}</span></div>
                                        </div>
                                        <div class="right-icon">
                                            <i class="icofont-bag fs-3 color-light-orange"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="left-info">
                                            <span class="text-muted">Total Sold Out</span>
                                            <div><span class="fs-6 fw-bold me-2">{{ count(App\Models\Product::where('status',0)->get()) }}</span></div>
                                        </div>
                                        <div class="right-icon">
                                            <i class="icofont-star fs-3 color-lightyellow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="left-info">
                                            <span class="text-muted">Total Available Products</span>
                                            <div><span class="fs-6 fw-bold me-2">{{ count(App\Models\Product::where('status',1)->get()) }}</span></div>
                                        </div>
                                        <div class="right-icon">
                                            <i class="icofont-bag fs-3 color-lavender-purple"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="left-info">
                                            <span class="text-muted">Subscribers</span>
                                            <div><span class="fs-6 fw-bold me-2">{{ count(App\Models\Subscriber::all()) }}</span></div>
                                        </div>
                                        <div class="right-icon">
                                            <i class="icofont-student-alt fs-3 color-light-orange"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="left-info">
                                            <span class="text-muted">Total Messages</span>
                                            <div><span class="fs-6 fw-bold me-2">{{ count(App\Models\CustomerMessage::all()) }}</span></div>
                                        </div>
                                        <div class="right-icon">
                                            <i class="icofont-ui-message fs-3 color-light-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- row end -->
                    </div>
                </div>
            </div>
        </div><!-- Row end  -->
    </div>
</div>
@endsection
