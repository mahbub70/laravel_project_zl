@extends('public.layouts.app')

@section('title')
    <title>About us - Zaman's Laptop</title>
@endsection

@section('css')
    <style>
        .owl-controls {
            display: none !important;
        }

        .big-image img {
            width: 100%;
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
                                <li class="breadcrumb-item active" aria-current="page">About US</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- contact us area -->
    <section class="contact-style-2 pt-30 pb-35">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="left-side-content col-md-6">
                    <div class="big-image">
                        <img src="{{ asset('dashboard_assets/images/about_us') }}/{{ $about_us->image }}" alt="About Us Image">
                    </div>
                </div>
                <div class="right-side-content col-md-6">
                    <div class="text-content">
                        <div class="section-title mt-0 mb-2">
                            <h3>Wellcome to <span>{{ $about_company->company_name }}</span></h3>
                        </div>
                        <div class="content">
                            <p>{{ $about_us->about_text }}</p>
                        </div>
                    </div>
                    <div class="image-slider">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="one">
                                <div class="product-gallary-wrapper">
                                    <div class="product-gallary-active2 owl-carousel owl-arrow-style product-spacing">
                                        @foreach ($gallery_images as $key=>$image)
                                            <div class="product-item">
                                                <div class="product-thumb">
                                                    <a href="javascript:void(0)">
                                                        <img src="{{ asset('dashboard_assets/images/about_us_gallery') }}/{{ $image->image }}" class="pri-img" alt="Gallery {{ $key+1 }}">
                                                    </a>
                                                </div>
                                            </div><!-- </div> end single item -->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Our Team Area -->
    {{-- <section class="our-team pt-30 pb-35"> 
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="section-title mt-0 mb-2">
                        <h3>Our Expert <span>Team Members</span></h3>
                    </div>
                  <p class="font-italic text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga corrupti facilis eius quia suscipit doloribus? Maxime quasi aliquid quod aperiam at facere, voluptatibus placeat voluptas id, nam autem corrupti quo reprehenderit deserunt incidunt vel? Eos, accusamus quia. Corporis repellendus, labore eaque quos accusamus asperiores placeat quo, quas quod itaque illo.</p>
                </div>
            </div>
          
            <div class="row text-center">
                <!-- Team item-->
                <div class="col-xl-3 col-sm-6 mb-5">
                  <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-4.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">Manuella Nevoresky</h5><span class="small text-uppercase text-muted">CEO - Founder</span>
                    <ul class="social mb-0 list-inline mt-3">
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-instagram"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                  </div>
                </div>
                <!-- End-->
                
                <!-- Team item-->
                <div class="col-xl-3 col-sm-6 mb-5">
                  <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-3.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">Samuel Hardy</h5><span class="small text-uppercase text-muted">CEO - Founder</span>
                    <ul class="social mb-0 list-inline mt-3">
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-instagram"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                  </div>
                </div>
                <!-- End-->
          
                <!-- Team item-->
                <div class="col-xl-3 col-sm-6 mb-5">
                  <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-2.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">Tom Sunderland</h5><span class="small text-uppercase text-muted">CEO - Founder</span>
                    <ul class="social mb-0 list-inline mt-3">
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-instagram"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                  </div>
                </div>
                <!-- End-->
          
                <!-- Team item-->
                <div class="col-xl-3 col-sm-6 mb-5">
                  <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-1.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">John Tarly</h5><span class="small text-uppercase text-muted">CEO - Founder</span>
                    <ul class="social mb-0 list-inline mt-3">
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-instagram"></i></a></li>
                      <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                  </div>
                </div>
                <!-- End-->
          
            </div>
        </div>
    </section> --}}
@endsection

@section('js_script')
    
@endsection