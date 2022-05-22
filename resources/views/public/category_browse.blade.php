@extends('public.layouts.app')

@section('title')
    <title>{{ (count($products)>0)?$products[0]->name:'No Data' }} - Zaman's Laptop</title>
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

        .hm-1 .section-title.module-three {
            margin: 20px 0;
        }

        @media (max-width: 991px){
            .section-title .module-three {
                margin-top:0 !important;
            }
        }

    </style>
@endsection

@section('page_content')
    <!-- home product module three start -->
    <div class="home-module-three hm-1 fix">
        <div class="container-fluid">
            <div class="section-title module-three">
                @if (count($products)>0)
                    <h3>{{ $products[0]->name }}</h3>
                @endif
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="module-one">
                    <div class="module-four-wrapper custom-seven-column">
                        @foreach ($products as $product)
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
                                            <p><a href="{{ route('browse.category',Str::lower(preg_replace('/ /i', '_', $product->name))) }}">{{ $product->name }}</a></p>
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
                        @endforeach
                    @if (count($products) == 0)
                        <div class="d-block text-center p-2">No Data Found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- home product module three end -->

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
    
    {{-- Modal Script  --}}
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