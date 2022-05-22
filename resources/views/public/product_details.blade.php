@extends('public.layouts.app')

@section('title')
    <title>{{ $product->title }}</title>
@endsection

@section('css')
    <style>
        .slick-list .slick-track {
            transform: none !important;
        }
        .btn-cart {
            bottom: 10px !important;
        }
        .modal-content .loading {
            position: absolute;
            min-height: 60vh;
            background: #fff;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 999;
        }
    </style>
@endsection

@section('page_content')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Product details</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- product details wrapper start -->
    <div class="product-details-main-wrapper pb-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="product-large-slider mb-20">
                        @php 
                            $images = json_decode($product->images);
                        @endphp
                        @foreach ($images as $image)
                            <div class="pro-large-img">
                                <img src="{{ asset('dashboard_assets/images/product') }}/{{ $image }}" alt="" />
                                <div class="img-view">
                                    <a class="img-popup" href="{{ asset('dashboard_assets/images/product') }}/{{ $image }}"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="pro-nav">
                        @foreach ($images as $thumb_image)
                            <div class="pro-nav-thumb">
                                <img src="{{ asset('dashboard_assets/images/product') }}/{{ $thumb_image }}" alt="" />
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="product-details-inner">
                        <div class="product-details-contentt">
                            <div class="pro-details-name mb-10">
                                <h3>{{ $product->title }}</h3>
                            </div>
                            <div class="price-box mb-15">
                                <span class="regular-price"><span class="special-price">৳ {{ ($product->discount > 0)?($product->price - ($product->price * $product->discount)/100):$product->price }}</span></span>
                                <span class="old-price"><del>{{ ($product->discount > 0)?'৳' . $product->price:'' }}</del></span>
                            </div>
                            <div class="product-detail-sort-des pb-20">
                                <p>{{ Str::limit(strip_tags($product->description), 200, '...') }}</p>
                            </div>
                            <div class="pro-details-list pt-20">
                                <ul>
                                    <li><span>Brands :</span><a href="#">{{ $product->brand }}</a></li>
                                    <li><span>Product Code :</span>{{ $product->product_code }}</li>
                                    <li><span>Availability :</span>{{ ($product->status != 1)?'Out of Stock':'Available' }}</li>
                                </ul>
                            </div>
                            <div class="product-availabily-option mt-15 mb-15">
                                <h3>Available Options</h3>
                                <div class="color-optionn">
                                    <h4><sup>*</sup>color</h4>
                                    <ul>
                                        @php
                                            $colors = explode(',',$product->color);
                                        @endphp
                                        
                                        @foreach ($colors as $color)
                                            <li>
                                                <span>{{ $color }}</span>
                                            </li>
                                        @endforeach
                                    </ul> 
                                </div>
                            </div>
                            <div class="pro-quantity-box mb-30">
                                <div class="qty-boxx">
                                    @if ($product->phone != null)
                                        <h3>Contact 1 : <a href="tel:{{ $product->phone }}">{{ $product->phone }}</a></h3>
                                    @endif
                                    @if($product->optional_phone != null)
                                        <h3>Contact 2 : <a href="tel:{{ $product->optional_phone }}">{{ $product->optional_phone }}</a></h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product details wrapper end -->

    <!-- product details reviews start -->
    <div class="product-details-reviews pb-30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-info mt-half">
                        <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="nav_desctiption" data-toggle="pill" href="#tab_description" role="tab" aria-controls="tab_description" aria-selected="true">Description</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab_description" role="tabpanel" aria-labelledby="nav_desctiption">
                                <p>{!! $product->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <!--  Start related-product -->
    <div class="related-product-area mb-40">
        <div class="container-fluid">
            <div class="section-title">
                <h3><span>Related</span> product </h3>
            </div>
            <div class="flash-sale-active4 owl-carousel owl-arrow-style">
                @foreach ($related_products as $item)
                    <div class="product-item mb-30">
                        <div class="product-thumb">
                            <a href="{{ route('public.product_details',$item->product_code) }}">
                                <img src="{{ asset('/dashboard_assets/images/thumbnail/125x125') }}/{{ $item->thumbnail }}" class="pri-img" alt="">
                            </a>
                            <div class="box-label">
                                <div class="label-product label_new">
                                    <span>new</span>
                                </div>
                                @if ($item->discount > 0)
                                    <div class="label-product label_sale">
                                        <span>{{ $item->discount .' ' }}%</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="product-caption">
                            <div class="manufacture-product">
                                <p><a href="#">{{ $item->brand }}</a></p>
                            </div>
                            <div class="product-name">
                                <h4><a href="{{ route('public.product_details',$item->product_code) }}">{{ $item->title }}</a></h4>
                            </div>
                            <div class="price-box">
                                <span class="regular-price"><span class="special-price">৳ {{ ($item->discount > 0)?($item->price - ($item->price * $item->discount)/100):$item->price }}</span></span>
                                <span class="old-price"><del>{{ ($item->discount > 0)?'৳' . $item->price:'' }}</del></span>
                            </div>
                            <button class="btn-cart quick_view_btn" type="button" title="Quick view" data-target="#quickk_view" data-toggle="modal" data-identity="{{ $item->id }}">Quick View</button>
                        </div>
                    </div><!-- </div> end single item -->
                @endforeach
            </div>
        </div>
    </div> 
    <!--  end related-product -->

    <!-- Quick view modal start -->
    <div class="modal fade" id="quickk_view">
        <div class="container">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="loading d-flex justify-content-center align-items-center">
                        <div class="animation">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider-modal mb-20">

                                </div>
                                <div class="pro-nav-modal">
                                    
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-inner">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick view modal end -->
@endsection

@section('js_script')
    <script>
        // product details slider active
		$('.product-large-slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			arrows: false,
			asNavFor: '.pro-nav'
		});

		// slick carousel active
		$('.pro-nav').slick({
			slidesToShow: 5,
			slidesToScroll: 1,
			prevArrow: '<button type="button" class="arrow-prev"><i class="fa fa-long-arrow-left"></i></button>',
			nextArrow: '<button type="button" class="arrow-next"><i class="fa fa-long-arrow-right"></i></button>',
			asNavFor: '.product-large-slider',
			centerMode: true,
			arrows: true,
			centerPadding: 0,
			focusOnSelect: true
		});
    </script>

    {{-- Script For Modal --}}
    <script>
        $('.quick_view_btn').click(function(){
            $('.loading').addClass('d-flex');
            $('.loading').removeClass('d-none');
            var product_identity = $(this).attr('data-identity');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/find-product",
                data: {
                    'product_identity': product_identity,
                },
                dataType:'json',
                success: function (data) {
                    setTimeout(function() {
                        $('.loading').removeClass('d-flex');
                        $('.loading').addClass('d-none');
                    }, 600);
                    var images = JSON.parse(data.images);
                    var image_place = "";
                    var thumb_image = "";
                    Object.keys(images).forEach(function(item){
                        image_place += `<div class="pro-large-img">
                                        <img src="/dashboard_assets/images/product/${images[item]}" alt="${item}"/>
                                    </div>`
                        thumb_image += `<div class="pro-nav-thumb">
                                        <img src="/dashboard_assets/images/product/${images[item]}" alt="${item}"/>
                                    </div>`
                    });

                    var colors = data.color.toString().split(',');
                    var colorPlace = '';
                    colors.forEach(function(item){
                        colorPlace += ` <li>
                                            <a class="text-dark" href="javascript:void(0)">${item}</a>
                                        </li>`;
                    });

                    var product_details = `<div class="product-details-contentt">
                                        <div class="pro-details-name mb-10">
                                            <h3>${data.title}</h3>
                                        </div>
                                        <div class="price-box mb-15">
                                            <span class="regular-price"><span class="special-price">৳ ${data.price}</span></span>
                                            <span class="old-price">Discount: ${data.discount} %</span>
                                        </div>
                                        <div class="product-detail-sort-des pb-20">
                                            <p>${data.description}</p>
                                        </div>
                                        <div class="product-availabily-option mt-15 mb-15">
                                            <h3>Available Options</h3>
                                            <div class="color-optionn">
                                                <h4><sup>*</sup>color</h4>
                                                <ul>
                                                    ${colorPlace}
                                                </ul> 
                                            </div>
                                        </div>
                                        <div>
                                            <h6><a href="tel:${data.phone}">Contact: ${data.phone}</a></h6>    
                                        </div>
                                    </div>`;

                    $('.product-details-inner').html(product_details);
                    $('.product-large-slider-modal').html(image_place);
                    $('.pro-nav-modal').html(thumb_image);

                    // product details slider active
                    $('.product-large-slider-modal').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        fade: true,
                        arrows: false,
                        asNavFor: '.pro-nav-modal'
                    });

                    // slick carousel active
                    $('.pro-nav-modal').slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        prevArrow: '<button type="button" class="arrow-prev"><i class="fa fa-long-arrow-left"></i></button>',
                        nextArrow: '<button type="button" class="arrow-next"><i class="fa fa-long-arrow-right"></i></button>',
                        asNavFor: '.product-large-slider-modal',
                        centerMode: true,
                        arrows: true,
                        centerPadding: 0,
                        focusOnSelect: true
                    });
                },

            })

        });
        $('#quickk_view').on('hidden.bs.modal', function(event){
            $('.product-large-slider-modal').slick('unslick');
            $('.pro-nav-modal').slick('unslick');
        })
    </script>
@endsection

