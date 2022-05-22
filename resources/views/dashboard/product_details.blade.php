@extends('layouts.app')

@section('title')
    <title>Product Details - Zaman's Laptop</title>
@endsection	

@section('content')
    <!-- Body: Body -->
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Product Details</h3>
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
                <div class="d-flex flex-row flex-wrap align-items-center justify-content-center justify-content-md-start bg-white p-3 border">
                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                        <div class="text-muted small">Brand</div>
                        <strong>{{ $data->brand }}</strong>
                    </div>
                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                        <div class="text-muted small">Model</div>
                        <strong>{{ $data->model }}</strong>
                    </div>
                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                        <div class="text-muted small">Regular Price</div>
                        <strong>৳ {{ $data->price }}</strong>
                    </div>
                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                        <div class="text-muted small">Category</div>
                        <strong>{{ $data->category->name }}</strong>
                    </div>
                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                        <div class="text-muted small">Created At</div>
                        <strong>
                            {{ (($data->created_at != null)?((now()->subdays(29) > $data->created_at)?$data->created_at->format('d-m-Y'):$data->created_at->diffForHumans()):'') }}
                        </strong>
                    </div>
                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                        <div class="text-muted small">Status</div>
                        <strong class="{{ ($data->status != 1)?'text-danger':'' }}">{{ ($data->status == 1)?'Available':'Sold' }}</strong>
                    </div>
                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                        <div class="text-muted small">Posted By</div>
                        <strong>{{ $data->user->name }}</strong>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-details">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="product-details-image mt-50">
                                            <div class="product-thumb-image">
                                                <div class="product-thumb-image-active nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                    @php
                                                        $images_array = json_decode($data->images, true);
                                                        $loop_count = 0;
                                                    @endphp
                                                    
                                                    @foreach ($images_array as $key=>$image)
                                                        <a class="single-thumb {{ ($loop_count == 0)?'active':'' }}" id="{{ $key }}" data-bs-toggle="pill" href="#v-pills-{{ $key }}" role="button" aria-controls="v-pills-{{ $key }}">
                                                            <img src="{{ asset('/dashboard_assets/images/product/') }}/{{ $image }}" alt="">
                                                        </a>
                                                        @php
                                                            $loop_count++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="product-image">
                                                <div class="product-image-active tab-content" id="v-pills-tabContent">
                                                    @php
                                                        $second_loop_count = 0;
                                                    @endphp

                                                    @foreach ($images_array as $key=>$image)
                                                        <a class="single-image tab-pane fade {{ ($second_loop_count == 0)?'active show':'' }}" id="v-pills-{{ $key }}" role="tabpanel" aria-labelledby="{{ $key }}">
                                                            <img src="{{ asset('/dashboard_assets/images/product/') }}/{{ $image }}" alt="">
                                                        </a>
                                                        @php
                                                            $second_loop_count++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-auto text-end mb-2">
                                            <a href="{{ route('product_status.update',$data->product_code) }}" class="btn {{ ($data->status != 1)?'btn-outline-info':'btn-outline-danger' }}">Mark as {{ ($data->status != 1)?'Available':'Sold' }}</a>
                                            <a href="{{ route('product.edit_form',$data->product_code) }}" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                                        </div>
                                        <div class="product-details-content mt-45">
                                            <h2 class="fw-bold fs-4">{{ $data->title }}</h2>
                                            <div class="product-select-wrapper flex-wrap">
                                                <div class="select-item">
                                                    <h6 class="select-title fw-bold">Color</h6>
                                                    @php
                                                        $color_array = explode(',',$data->color);
                                                    @endphp
                                                    <div class="">
                                                        @foreach ($color_array as $item)
                                                            <li>{{ $item }}</li>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-price">
                                                <h6 class="price-title fw-bold mb-0">Price</h6>
                                                <p class="sale-price mt-0">৳ {{ ($data->discount > 0)?($data->price - ($data->price * $data->discount)/100):$data->price }}</p>
                                                <p class="regular-price text-danger">{{ ($data->discount > 0)?'৳' . $data->price:'' }}</p>
                                                @if ($data->discount > 0)
                                                    <span class="badge bg-info ms-3">Discount {{ $data->discount }}%</span> 
                                                @endif
                                            </div>
                                            <p>{{ Str::limit(strip_tags($data->description), 150, '...') }}</p>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Row end  -->  

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs tab-body-header rounded  d-inline-flex" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#descriptions" role="tab">Descriptions</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="descriptions">
                                <div class="card-body">
                                    {!! $data->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Row end  -->  

        </div>
    </div>
@endsection