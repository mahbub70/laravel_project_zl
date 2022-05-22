@extends('public.layouts.app')

@section('title')
    <title>Home - Zaman's Laptop</title>
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

        .slider-text h1{
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
            margin-top: 173px;
        }

        .brand-area .owl-stage {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-area .owl-stage div li a img {
            height: auto !important;
        }

    </style>
@endsection

@section('page_content')
    <!-- slider area start -->
    <div class="banner-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 d-block desktop-category">
                    <div class="categories-menu-bar cat-menu-style2">
                        <div class="categories-menu-btn ha-toggle">
                            <div class="left">
                                <i class="lnr lnr-text-align-left"></i>
                                <span>Browse categories</span>
                            </div>
                            <div class="right">
                                <i class="lnr lnr-chevron-down"></i>
                            </div>
                        </div>
                        <nav class="categorie-menus ha-dropdown">
                            <ul id="menu2">
                                @foreach ($categories as $key=>$category)
                                    <li class="{{ ($key >= 7)?'category-item-parent hidden':'' }}"><a href="{{ route('browse.category',Str::lower(preg_replace('/ /i', '_', $category->name))) }}">{{ $category->name }}</a></li>
                                @endforeach
                                @if (count($categories) >= 7)
                                    <li class="category-item-parent"><a class="more-btn" href="#" role="menuitem" tabindex="0">More Categories</a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-6 col-12 slick-banner-wrap">
                    @if(count($sliders) > 0)
                        <div class="hero-slider-active hero-style-2 slick-dot-style slider-arrow-style">
                            @foreach ($sliders as $slider)
                                <div class="single-slider d-flex align-items-center" style="background-image: url('{{ asset('dashboard_assets/images/slider') }}/{{ $slider->image }}');">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12 d-flex align-items-center">
                                                <div class="slider-text">
                                                    <h1>{{ $slider->slider_text }}</h1>
                                                    @if ($slider->button_text != null)
                                                        <a class="btn-1 home-btn" href="{{ $slider->button_link }}">{{ $slider->button_text }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-lg-3 col-12">
                    <div class="home2-banner-right">
                        @foreach ($banners as $banner)
                            <div class="banner-right-thumb mb-30">
                                <a href="#">
                                    <img src="{{ asset('dashboard_assets/images/promo_banner') }}/{{ $banner->image }}" alt="">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider area end -->

    <!-- feature area start -->
    <div class="feature-style-one pt-50 pb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="feature-inner fix">
                        <div class="col">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <img src="{{ asset('public_assets/img/icon/wrapper1.png') }}" alt="">
                                </div>
                                <div class="feature-content">
                                    <h4>free shipping</h4>
                                    <p>free shipping on all us order</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <img src="{{ asset('public_assets/img/icon/wrapper2.png') }}" alt="">
                                </div>
                                <div class="feature-content">
                                    <h4>Support 24/7</h4>
                                    <p>Contact us 24 hours a day</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <img src="{{ asset('public_assets/img/icon/wrapper3.png') }}" alt="">
                                </div>
                                <div class="feature-content">
                                    <h4>100% Money Back</h4>
                                    <p>You have 30 days to Return</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <img src="{{ asset('public_assets/img/icon/wrapper4.png') }}" alt="">
                                </div>
                                <div class="feature-content">
                                    <h4>90 Days Return</h4>
                                    <p>If goods have problems</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <img src="{{ asset('public_assets/img/icon/wrapper5.png') }}" alt="">
                                </div>
                                <div class="feature-content">
                                    <h4>Payment Secure</h4>
                                    <p>We ensure secure payment</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- feature area end -->

    <!-- Latest product wrapper area start -->
    <div class="product-wrapper fix pt-15 pb-20">
        <div class="container-fluid">
            <div class="section-title product-spacing">
                <h3><span>our</span> product</h3>
                <div class="boxx-tab">
                    <ul class="nav my-tab">
                        @php
                            $first_item = 0;
                        @endphp
                        @foreach ($categories as $key=>$category)
                            @if(count(App\Models\Product::where('category_id',$category->id)->get()) > 0)
                                @php
                                    $first_item++;
                                @endphp
                                <li>
                                    <a class="{{ ($first_item == 1)?'active':'' }}" data-toggle="tab" href="#{{ $category->name . '_' . $key }}">{{ $category->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                @php
                    $tab_first_item = 0;
                @endphp
                @foreach ($categories as $key=>$category)
                    @if(count(App\Models\Product::where('category_id',$category->id)->get()) > 0)
                    @php
                        $tab_first_item++;
                    @endphp
                    
                    <div class="tab-pane fade {{ ($tab_first_item == 1)?'show active':'' }}" id="{{ $category->name . '_' . $key }}">
                        <div class="product-gallary-wrapper">
                            <div class="product-gallary-active2 owl-carousel owl-arrow-style product-spacing">
                                @foreach ($products as $product)
                                    @if ($category->id == $product->category_id)
                                        <div class="product-item">
                                            <div class="product-thumb">
                                                <a href="{{ route('public.product_details',$product->product_code) }}">
                                                    <img src="{{ asset('dashboard_assets/images/thumbnail/287x287') }}/{{ $product->thumbnail }}" class="pri-img" alt="">
                                                </a>
                                                <div class="box-label">
                                                    <div class="label-product label_new">
                                                        <span>new</span>
                                                    </div>
                                                    @if ($product->discount > 0)
                                                        <div class="label-product label_sale">
                                                            <span>-{{ $product->discount . '%' }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="product-caption">
                                                <div class="manufacture-product">
                                                    <p><a href="#">{{ $category->name }}</a></p>
                                                </div>
                                                <div class="product-name">
                                                    <h4><a href="{{ route('public.product_details',$product->product_code) }}">{{ $product->title }}</a></h4>
                                                </div>
                                                <div class="price-box">
                                                    <span class="regular-price"><span class="special-price">{{ ($product->price > 0)?('৳ ' . $product->price - ($product->price * $product->discount)/100):'৳ ' .$product->price }}</span></span>

                                                    <span class="old-price"><del>{{ ($product->discount != 0)?'৳ ' .$product->price:'' }}</del></span>
                                                </div>
                                                <button class="btn-cart quick_view_btn" type="button" title="Quick view" data-target="#quickk_view" data-toggle="modal" data-identity="{{ $product->id }}">Quick View</button>
                                            </div>
                                        </div><!-- </div> end single item -->
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- Latest product wrapper area start -->

    <!-- home product module three start -->
    <div class="home-module-three hm-1 fix">
        <div class="container-fluid">
            <div class="section-title module-three">
                <h3><span>Hot</span> Collection</h3>
                <div class="boxx-tab">
                    <ul class="nav my-tab">
                        <li>
                            <a class="active" data-toggle="tab" href="#">Hot Collection</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="module-one">
                    <div class="module-four-wrapper custom-seven-column">
                        @foreach ($products as $product)
                            @if($product->position == 1)
                                <div class="col mb-30">
                                    <div class="product-item">
                                        <div class="product-thumb">
                                            <a href="{{ route('public.product_details',$product->product_code) }}">
                                                <img src="{{ asset('dashboard_assets/images/thumbnail/125x125') }}/{{ $product->thumbnail }}" class="pri-img" alt="">
                                            </a>
                                            <div class="box-label">
                                                <div class="label-product label_new">
                                                    <span></span>
                                                </div>
                                                <div class="label-product label_sale">
                                                    <span>-{{ $product->discount . '%' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-caption">
                                            <div class="manufacture-product">
                                                <p><a href="#">{{ $category->name }}</a></p>
                                            </div>
                                            <div class="product-name">
                                                <h4><a href="{{ route('public.product_details',$product->product_code) }}">{{ $product->title }}</a></h4>
                                            </div>
                                            <div class="price-box">
                                                <span class="regular-price"><span class="special-price">{{ ($product->price > 0)?('৳ ' . $product->price - ($product->price * $product->discount)/100):'৳ ' .$product->price }}</span></span>

                                                <span class="old-price"><del>{{ ($product->discount != 0)?'৳ ' .$product->price:'' }}</del></span>
                                            </div>
                                            <button class="btn-cart quick_view_btn" type="button" title="Quick view" data-target="#quickk_view" data-toggle="modal" data-identity="{{ $product->id }}">Quick View</button>
                                        </div>
                                    </div><!-- </div> end single item -->
                                </div> <!-- single item end -->
                            @endif
                        @endforeach     
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- home product module three end -->


    {{-- Indivisual Caetgory Product Start --}}
    @foreach ($categories as $category)
        @if(count(App\Models\Product::where('category_id',$category->id)->get()) > 0)
            <div class="home-module-four mb-5">
                <div class="container-fluid">
                    <div class="section-title mt-0">
                        <h3>{{ $category->name }}</h3>
                    </div>
                    <div class="pro-module-four-active owl-carousel owl-arrow-style">
                        @foreach ($products as $product)
                            @if ($category->id == $product->category_id)
                                <div class="product-module-four-item">
                                    <div class="product-module-caption">
                                        <div class="manufacture-com">
                                            <p><a href="#">{{ $product->name }}</a></p>
                                        </div>
                                        <div class="product-module-name">
                                            <h4><a href="{{ route('public.product_details',$product->product_code) }}">{{ $product->title }}</a></h4>
                                        </div>
                                        <div class="price-box-module">
                                            <span class="regular-price"><span class="special-price">{{ ($product->price > 0)?('৳ ' . $product->price - ($product->price * $product->discount)/100):'৳ ' .$product->price }}</span></span>

                                            <span class="old-price"><del>{{ ($product->discount != 0)?'৳ ' .$product->price:'' }}</del></span>
                                        </div>
                                    </div>
                                    <div class="product-module-thumb">
                                        <a href="{{ route('public.product_details',$product->product_code) }}">
                                            <img src="{{ asset('dashboard_assets/images/thumbnail/125x158') }}/{{ $product->thumbnail }}" alt="">
                                        </a>
                                    </div>
                                </div> <!-- end single item -->
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    {{-- Indivisual Caetgory Product End --}}

    <!-- brand sale area start -->
    <div class="brand-area pb-20">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3><span>Brand</span> sale</h3>
                    </div>
                </div>
                <div class="col-12">
                    <ul class="nav brand-active owl-carousel">
                        @foreach ($brands as $key=>$brand)
                            <li>
                                <a class="active" href="#brand-{{ $key+1 }}" data-toggle="tab">
                                    <img src="{{ asset('dashboard_assets/images/brand') }}/{{ $brand->image }}" alt="">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- brand sale area end -->

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
                                <div class="product-large-slider mb-20">

                                </div>
                                <div class="pro-nav">
                                    
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

    {{-- Get Height --}}
    <script>
        var boxTabHeight = document.querySelector('.boxx-tab').getBoundingClientRect().height;
        var spacing = document.querySelector('.product-spacing');
        var pxCalculate = boxTabHeight + 23;
        spacing.style.marginBottom = `${pxCalculate}px`;

    </script>

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
                    var images = JSON.parse(data.images);
                    var image_place = "";
                    var thumb_image = "";
                    Object.keys(images).forEach(function(item){
                        image_place += `<div class="pro-large-img">
                                        <img src="dashboard_assets/images/product/${images[item]}" alt="${item}"/>
                                    </div>`
                        thumb_image += `<div class="pro-nav-thumb">
                                        <img src="dashboard_assets/images/product/${images[item]}" alt="${item}"/>
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

                    $('.product-large-slider').html(image_place);
                    $('.pro-nav').html(thumb_image);

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

                    setTimeout(function() {
                        $('.loading').removeClass('d-flex');
                        $('.loading').addClass('d-none');
                    }, 600);
                },

            })

        });
        $('#quickk_view').on('hidden.bs.modal', function(event){
            $('.product-large-slider').slick('unslick');
            $('.pro-nav').slick('unslick');
        })
    </script>
    
@endsection