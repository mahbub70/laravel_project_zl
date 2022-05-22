@extends('layouts.app')

@section('title')
    <title>Products - Zaman's Laptop</title>
@endsection


@section('content')
    <!-- Body: Body -->
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Products</h3>
                        <div class="btn-set-task w-sm-100">
                            <a href="{{ route('product.add_from') }}" class="btn btn-primary py-2 px-5 w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i> Add Product</a>
                        </div>
                    </div>
                </div>
            </div> <!-- Row end  -->
            {{--  Message From Controller--}}
            @if (session('faild'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Faild!</strong> {!! session('faild') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row g-3 mb-3">
                @foreach ($data as $item)
                    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="card mb-3 bg-transparent p-2">
                            <div class="card border-0 mb-1">
                                <div class="form-check form-switch position-absolute top-0 end-0 py-3 px-3 d-none d-md-block">
                                    <a href="{{ route('product.edit_form',$item->product_code) }}" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                                    
                                    <a href="{{ route('product.delete',encrypt($item->id)) }}" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></a>
                                </div>
                                <div class="card-body d-flex align-items-center flex-column flex-md-row">
                                    <a href="{{ route('product.details', $item->product_code) }}">
                                        <img class="w220 rounded img-fluid" src="{{ asset('dashboard_assets/images/thumbnail/287x287') }}/{{ $item->thumbnail }}" alt="">
                                    </a>
                                    <div class="ms-md-4 m-0 mt-4 mt-md-0 text-md-start text-center w-100">
                                        <a href="{{ route('product.details', $item->product_code) }}">
                                            <h4 class="mb-3 fw-bold">{{ $item->title }}<span class="text-muted lead fw-light d-block mt-1"><span class="font-weight-bold">Code:</span> {{ $item->product_code }}</span></h4>
                                        </a>
                                        <div class="d-flex flex-row flex-wrap align-items-center justify-content-center justify-content-md-start">
                                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                                <div class="text-muted small">Brand</div>
                                                <strong>{{ $item->brand }}</strong>
                                            </div>
                                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                                <div class="text-muted small">Model</div>
                                                <strong>{{ $item->model }}</strong>
                                            </div>
                                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                                <div class="text-muted small">Price</div>
                                                <strong>৳ {{ $item->price }}</strong>
                                            </div>
                                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                                <div class="text-muted small">Category</div>
                                                <strong>{{ $item->category->name }}</strong>
                                            </div>
                                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                                <div class="text-muted small">Created At</div>
                                                <strong>
                                                    {{ (($item->created_at != null)?((now()->subdays(29) > $item->created_at)?$item->created_at->format('d-m-Y'):$item->created_at->diffForHumans()):'') }}
                                                </strong>
                                            </div>
                                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                                <div class="text-muted small">Status</div>
                                                <strong class="{{ ($item->status != 1)?'text-danger':'' }}">{{ ($item->status == 1)?'Available':'Sold' }}</strong>
                                            </div>
                                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                                <div class="text-muted small">Posted By</div>
                                                <strong>{{ $item->user->name }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="row mb-3">
                    <div class="pagination d-flex justify-content-end col-12">
                        <div class="pagination_wrp">
                            {{ $data->onEachSide(3)->links() }}
                        </div>
                    </div>
                </div>
            </div> <!-- Row end  -->
        </div>
    </div>
@endsection