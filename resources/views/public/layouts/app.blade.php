<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page Title -->
	@yield('title')
	<!--Fevicon-->
	<link rel="icon" href="{{ asset('public_assets/img/logo/zaman_it_logo.png') }}" type="image/x-icon" />
	<!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('public_assets/css/bootstrap.min.css') }}">
    <!-- linear-icon -->
    <link rel="stylesheet" href="{{ asset('public_assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public_assets/css/linear-icon.css') }}">
    <!-- all css plugins css -->
    <link rel="stylesheet" href="{{ asset('public_assets/css/plugins.css') }}">
    <!-- default style -->
    <link rel="stylesheet" href="{{ asset('public_assets/css/default.css') }}">
    <!-- Main Style css -->
    <link rel="stylesheet" href="{{ asset('public_assets/css/style.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('public_assets/css/responsive.css') }}">

    <!-- Modernizer JS -->
    <script src="{{ asset('public_assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>

    <style>
        .header-middle-inner{
            transition: 0.5s;
            visibility: hidden;
            opacity: 0;
        }
        .header-middle-inner.active{
            visibility: visible;
            opacity: 1;
        }
        .top-cat .nice-select{
            width: 150px;
        }
        body.loading {
            overflow: hidden !important;
        }
        .mini-cart-option ul li {
            font-size: 15px !important;
        }

        .modal-body .product-detail-sort-des {
            height: 30vh;
            overflow-y: scroll;
        }
    </style>

    @yield('css')

</head>
<body class="loading">
    {{-- Loading Animation --}}
    <div class="loading-animation">
        <div class="content">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
                <g id="Group_5" data-name="Group 5" transform="translate(-505 -355)">
                  <g id="Ellipse_1" data-name="Ellipse 1" transform="translate(505 355)" fill="#fff" stroke="#707070" stroke-width="1">
                    <circle cx="40" cy="40" r="40" stroke="none"/>
                    <circle cx="40" cy="40" r="39.5" fill="none"/>
                  </g>
                  <g id="Group_4" data-name="Group 4" transform="translate(515.909 370.065)">
                    <path id="Path_1" data-name="Path 1" d="M544.52,362.2a5.019,5.019,0,1,1-5.116-4.918A5.018,5.018,0,0,1,544.52,362.2Z" transform="translate(-511.093 -357.28)" fill="#c73b1a" fill-rule="evenodd"/>
                    <g id="Group_3" data-name="Group 3" transform="translate(26.716 1.122)">
                      <g id="Group_1" data-name="Group 1" transform="translate(0.315 2.985)">
                        <path id="Path_2" data-name="Path 2" d="M538.315,365.015a1.678,1.678,0,0,1-.331-1.038c-.013-.309-.009-.617-.019-.926,0-.067.01-.09.083-.09.318,0,.633-.008.95-.018.071,0,.087.019.089.088a.276.276,0,0,0,.2.3.391.391,0,0,0,.414-.1.278.278,0,0,0,.05-.224c0-.058.017-.078.077-.078.321,0,.64-.008.961-.017.063,0,.084.013.084.08,0,.328.017.656.012.983a1.62,1.62,0,0,1-.474,1.2A1.41,1.41,0,0,1,538.315,365.015Z" transform="translate(-537.958 -361.117)" fill="#fff" fill-rule="evenodd"/>
                        <path id="Path_3" data-name="Path 3" d="M540.354,361.63a1.743,1.743,0,0,1,.445,1.164c0,.051-.012.071-.068.073-.328,0-.655.009-.984.018-.056,0-.069-.021-.07-.073,0-.181,0-.362-.009-.542a.261.261,0,0,0-.209-.293.083.083,0,0,1-.068-.1c0-.2,0-.4-.011-.6,0-.071.016-.087.088-.08A1.436,1.436,0,0,1,540.354,361.63Z" transform="translate(-537.89 -361.199)" fill="#fff" fill-rule="evenodd"/>
                        <path id="Path_4" data-name="Path 4" d="M538.443,361.59a1.449,1.449,0,0,1,.788-.384c.075-.009.093.008.093.084,0,.192,0,.385.012.576,0,.062-.006.1-.079.123a.253.253,0,0,0-.187.275c.006.189.006.376.012.565,0,.052-.013.07-.067.071-.324,0-.648.008-.971.017-.07,0-.087-.019-.086-.087A1.708,1.708,0,0,1,538.443,361.59Z" transform="translate(-537.958 -361.199)" fill="#fff" fill-rule="evenodd"/>
                        <path id="Path_5" data-name="Path 5" d="M539.475,362.13a.2.2,0,0,1,.06.146c0,.248.01.5.011.744a.2.2,0,0,1-.178.222c-.109.005-.19-.08-.194-.217-.008-.248-.01-.5-.014-.744a.2.2,0,0,1,.124-.2A.157.157,0,0,1,539.475,362.13Z" transform="translate(-537.9 -361.158)" fill="#fff" fill-rule="evenodd"/>
                      </g>
                      <g id="Group_2" data-name="Group 2">
                        <path id="Path_6" data-name="Path 6" d="M541.046,359.023v0a.312.312,0,0,0-.045.046.136.136,0,0,0-.029.03.367.367,0,0,0-.044.046.164.164,0,0,0-.03.03.456.456,0,0,0-.044.046.261.261,0,0,0-.029.03c-.009.01-.015.008-.025,0a1.78,1.78,0,0,0-.2-.17l-.007-.005a.464.464,0,0,0-.064-.044,1.345,1.345,0,0,0-.157-.1,1.2,1.2,0,0,0-.152-.074l-.008,0a.424.424,0,0,0-.068-.028.376.376,0,0,0-.068-.025,1.038,1.038,0,0,0-.159-.049.375.375,0,0,0-.076-.018.482.482,0,0,0-.076-.017,1.112,1.112,0,0,0-.143-.021l-.007,0a2.12,2.12,0,0,0-.416,0,.924.924,0,0,0-.121.016,1.049,1.049,0,0,0-.141.027.357.357,0,0,0-.075.019.381.381,0,0,0-.075.021,1.023,1.023,0,0,0-.156.056.376.376,0,0,0-.067.028.383.383,0,0,0-.067.031l-.008,0a1.214,1.214,0,0,0-.15.082,1.237,1.237,0,0,0-.148.1.526.526,0,0,0-.067.05l-.007.006a1.652,1.652,0,0,0-.2.177c-.009.009-.016.012-.025,0a.155.155,0,0,0-.03-.028.377.377,0,0,0-.046-.045.205.205,0,0,0-.03-.029c-.015-.016-.03-.03-.047-.045a.208.208,0,0,0-.035-.033.254.254,0,0,0-.042-.04v0l.106-.1c.06-.057.125-.109.191-.16l.152-.1.072-.044.073-.042a.408.408,0,0,0,.067-.035l.007,0,.074-.036.15-.061.074-.027.007,0,0,0,.138-.041h0a2.46,2.46,0,0,1,.411-.07c.013,0,.027,0,.04-.006h.048s.007,0,.012,0l.093,0c.005,0,.01,0,.012,0h.049c0,.005.008,0,.012,0a2.166,2.166,0,0,1,.273.024c.059.007.117.02.176.03l.036.009.115.029.076.024.152.055.066.028h0l.005,0c.026.013.052.025.08.037l.073.039.079.044.153.1,0,0,.072.051.028.022.048.038.126.11A.163.163,0,0,0,541.046,359.023Z" transform="translate(-537.657 -358.351)" fill="#fff" fill-rule="evenodd"/>
                        <path id="Path_7" data-name="Path 7" d="M539.361,360.925a.37.37,0,0,1-.077,0c-.023-.005-.047-.012-.07-.019a.319.319,0,0,1-.115-.092.307.307,0,0,1-.049-.13.449.449,0,0,1,0-.084l0-.007v-.006a.668.668,0,0,1,.028-.069.428.428,0,0,1,.067-.077l.048-.03a.487.487,0,0,1,.075-.024l.079,0,.008,0h.01l.008,0,.007,0h0l.008,0,.026.009a.3.3,0,0,1,.126.108l.024.048,0,.007,0,.007,0,.008a.289.289,0,0,1,.008.074c0,.023,0,.046-.007.068a.282.282,0,0,1-.1.147.484.484,0,0,1-.045.028A.435.435,0,0,1,539.361,360.925Z" transform="translate(-537.59 -358.253)" fill="#fff" fill-rule="evenodd"/>
                        <path id="Path_8" data-name="Path 8" d="M539.441,359h.007a.038.038,0,0,0,.019,0h.027l.14.019c.062.009.124.024.184.039l.144.046.08.033.08.038c.05.026.1.055.149.083l.036.024a1.818,1.818,0,0,1,.191.144l0,0h0l.029.027c.024.023.024.023,0,.047a.4.4,0,0,0-.029.03.613.613,0,0,0-.044.046.168.168,0,0,0-.029.031.262.262,0,0,0-.044.046.171.171,0,0,0-.03.03l-.025.025c-.006.008-.013.012-.021,0a.324.324,0,0,0-.028-.025.149.149,0,0,0-.034-.029.3.3,0,0,0-.044-.036h0l0,0a.973.973,0,0,0-.145-.1.872.872,0,0,0-.156-.079.017.017,0,0,0-.012-.005,1.281,1.281,0,0,0-.129-.046l0,0h-.008a.479.479,0,0,0-.075-.021,1.344,1.344,0,0,0-.453-.028.624.624,0,0,0-.087.013,1.015,1.015,0,0,0-.138.029.386.386,0,0,0-.074.024l-.008,0h0a.355.355,0,0,0-.063.024.235.235,0,0,0-.056.024l0,0h0s-.006,0-.01.005a.94.94,0,0,0-.153.085,1.168,1.168,0,0,0-.219.173c-.011.011-.021.028-.036.032s-.022-.02-.036-.026a.257.257,0,0,0-.034-.034.605.605,0,0,0-.046-.044.168.168,0,0,0-.031-.029.465.465,0,0,0-.046-.045.2.2,0,0,0-.03-.029l-.008-.009c-.013-.008-.011-.015,0-.025s.023-.023.034-.035a1.978,1.978,0,0,1,.23-.188l.145-.089.079-.04.078-.035c.047-.019.094-.036.143-.053l.079-.023.071-.017.083-.017.141-.018a.455.455,0,0,0,.075-.005h.076A.458.458,0,0,0,539.441,359Z" transform="translate(-537.634 -358.32)" fill="#fff" fill-rule="evenodd"/>
                        <path id="Path_9" data-name="Path 9" d="M539.825,360.17a.649.649,0,0,0-.234-.147.518.518,0,0,0-.144-.038.174.174,0,0,0-.057-.006l-.011,0h-.016a.433.433,0,0,0-.074,0,.366.366,0,0,0-.084.013.521.521,0,0,0-.142.043.57.57,0,0,0-.154.09.428.428,0,0,0-.062.053.032.032,0,0,0-.011.013c-.014.013-.017-.005-.025-.007a.476.476,0,0,0-.046-.044.143.143,0,0,0-.031-.029.317.317,0,0,0-.046-.045.155.155,0,0,0-.03-.028.312.312,0,0,0-.046-.045l-.026-.028c.031-.032.066-.062.1-.093a1.585,1.585,0,0,1,.149-.1,1.444,1.444,0,0,1,.159-.072l.064-.02a1.612,1.612,0,0,1,.17-.034.246.246,0,0,0,.056-.005h.075a.317.317,0,0,0,.056,0,1.081,1.081,0,0,1,.153.023l.018,0,.075.02c.052.02.1.04.152.063s.1.061.152.094.07.057.1.088l-.028.034a4.493,4.493,0,0,1-.07.073.62.62,0,0,0-.045.046.242.242,0,0,0-.028.03.32.32,0,0,0-.041.043C539.843,360.161,539.84,360.183,539.825,360.17Z" transform="translate(-537.612 -358.289)" fill="#fff" fill-rule="evenodd"/>
                      </g>
                    </g>
                    <path id="Path_10" data-name="Path 10" d="M541.112,386.2a76.687,76.687,0,0,0-6.942,19.513h20.485l1.407-9.983H539.754Z" transform="translate(-511.108 -355.892)" fill="#10716c"/>
                    <path id="Path_11" data-name="Path 11" d="M551.389,368a34.681,34.681,0,0,0-13.64,9.907l-.075.086a51.677,51.677,0,0,0-7.262,11.388L532.028,378H512.164L513.625,368Z" transform="translate(-512.164 -356.765)" fill="#10716c"/>
                    <path id="Path_12" data-name="Path 12" d="M536.578,377.91H542.3l-.013.087h4.857c.77-.894,1.548-1.719,2.325-2.484l1.1-7.509h-.359A34.682,34.682,0,0,0,536.578,377.91Z" transform="translate(-510.993 -356.765)" fill="#0c4247"/>
                    <path id="Path_13" data-name="Path 13" d="M542.861,377.54h-5.786a51.591,51.591,0,0,0-7.263,11.389l-1.024,7.208h-1.9c-.65,1.9-1.156,3.643-1.544,5.127l-.659,4.749-.02.038-.007.08h9.968a76.687,76.687,0,0,1,6.942-19.513Z" transform="translate(-511.565 -356.308)" fill="#0c4247"/>
                    <path id="Path_14" data-name="Path 14" d="M536.581,377.457c-.025.029-.05.058-.074.087h5.786l.013-.087Z" transform="translate(-510.996 -356.312)" fill="#0c4247"/>
                    <path id="Path_15" data-name="Path 15" d="M528.913,406.674h5.509a76.766,76.766,0,0,1,6.941-19.513,49.392,49.392,0,0,1,6.153-9.078c.768-.895,1.548-1.719,2.323-2.484,8.48-8.324,17.068-9.267,18.967-9.374C538.946,365.637,530.162,400.837,528.913,406.674Z" transform="translate(-511.36 -356.851)" fill="#c73b1a"/>
                    <path id="Path_16" data-name="Path 16" d="M569.01,366.245c.233-.014.366-.014.385-.014a36.625,36.625,0,0,0-18.606,1.879,34.681,34.681,0,0,0-13.64,9.907l-.074.086a51.672,51.672,0,0,0-7.262,11.388,67.98,67.98,0,0,0-2.924,7.209c-.649,1.9-1.155,3.642-1.544,5.126l-.66,4.75-.018.038-.008.08h4.459C530.366,400.856,539.15,365.657,569.01,366.245Z" transform="translate(-511.565 -356.871)" fill="#ed4b14"/>
                  </g>
                </g>
            </svg>                      
        </div>
    </div>

    {{-- header area start --}}
    <header class="header-pos">
        <div class="header-middle home-header2 theme-bg">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-4 col-sm-4 col-12">
                        <div class="logo">
                            <a href="{{ route('index') }}"><img src="{{ asset('dashboard_assets/images/logo') }}/{{ $about_company->image }}" alt="Logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 col-12 order-sm-last">
                        <div class="header-middle-inner position-relative">
                            <form action="#" class="d-flex">
                                <div class="top-cat hm1">
                                    <div class="search-form">
                                         <select id="search_select">
                                            <optgroup label="Electronics">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <input type="text" class="top-cat-field" placeholder="Search by product name" id="search_input" autocomplete="false">
                                <input type="button" class="top-search-btn" value="Search">
                            </form>

                            <!-- Search Result Section -->
                            <div class="search_result_box position-absolute" style="display: none;" >
                                <div class="search_result_wrp">
                                    <div class="search_result_content">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-8 col-12 col-sm-8 order-lg-last">
                        <div class="mini-cart-option">
                            <ul>
                                <li class="font-weight-bold">
                                    <span>Email: </span> {{ $about_company->email }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-top-menu menu-style2 mb-20 sticker">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="top-main-menu">
                            <div class="main-menu">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li><a href="{{ route('index') }}">HOME</a></li>
                                        <li><a href="#">SHOP<span class="lnr lnr-chevron-down"></span></a>
                                            <ul class="dropdown">
                                                @foreach ($categories as $category)
                                                    <li><a href="{{ route('browse.category',Str::lower(preg_replace('/ /i', '_', $category->name))) }}">{{ $category->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        
                                        <li><a href="{{ route('public.contact_us') }}">CONTACT US</a></li>
                                        <li><a href="{{ route('public.about_us') }}">ABOUT US</a></li>
                                    </ul>
                                </nav>
                            </div> <!-- </div> end main menu -->
                            <div class="header-call-action">
                                <p><span class="lnr lnr-phone"></span>Hotline : <a href="tel:{{ $about_company->phone }}" class="text-dark">{{ $about_company->phone }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-block d-lg-none"><div class="mobile-menu"></div></div>
                </div>
            </div>
        </div>
    </header>
    {{-- header area end --}}

    @yield('page_content')

    {{-- scroll to top --}}
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    {{-- /End Scroll to Top --}}

     {{--footer area start--}}
    <footer>
        <!-- news-letter area start -->
        <div class="newsletter-group">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="newsletter-box">
                            <div class="newsletter-inner">
                                <div class="newsletter-title">
                                    <h3>Sign Up For Newsletters</h3>
                                    <p>Be the First to Know. Sign up for newsletter today</p>
                                </div>
                                <div class="newsletter-box">
                                    <form method="post" action="{{ route('subscriber.add') }}">
                                        @csrf
                                        <input type="email" id="mc-email" autocomplete="off" class="email-box" placeholder="enter your email" name="email" @error('email') autofocus @enderror value="{{ old('email') }}" @if(session('success')) autofocus @endif>
                                        @if (session('success'))
                                            <div class="alert alert-success">{!! session('success') !!}</div>
                                        @endif
                                        @error('email')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                        <button class="newsletter-btn" type="submit" id="mc-submit">subscribe !</button>
                                    </form>
                                </div>
                            </div>
                            <div class="link-follow">
                                <a href="{{ $about_company->facebook_link }}"><i class="fa fa-facebook"></i></a>
                                <a href="{{ $about_company->twitter_link }}"><i class="fa fa-twitter"></i></a>
                                <a href="{{ $about_company->linkedin_link }}"><i class="fa fa-linkedin"></i></a>
                                <a href="{{ $about_company->youtube_link }}"><i class="fa fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- news-letter area end -->
        <!-- footer top area start -->
        <div class="footer-top pt-50 pb-50">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="footer-single-widget">
                            <div class="widget-title">
                                <div class="footer-logo mb-30">
                                    <a href="{{ route('index') }}">
                                         <img src="{{ asset('dashboard_assets/images/logo') }}/{{ $about_company->image }}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <p></p>
                            </div>
                        </div>
                    </div> <!-- single widget end -->
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-single-widget">
                            <div class="widget-title">
                                <h4>Information</h4>
                            </div>
                            <div class="widget-body">
                                <div class="footer-useful-link">
                                    <ul>
                                        <li><a href="{{ route('index') }}">Home</a></li>
                                        <li><a href="{{ route('public.contact_us') }}">Contact Us</a></li>
                                        <li><a href="{{ route('public.about_us') }}">About Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- single widget end -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-single-widget">
                            <div class="widget-title">
                                <h4>contact us</h4>
                            </div>
                            <div class="widget-body">
                                <div class="footer-useful-link">
                                    <ul>
                                        <li><span>Address:</span> {{ $about_company->address }}</li>
                                        <li><span>email:</span> {{ $about_company->email }}</li>
                                        <li><span>Call us:</span> <strong>{{ $about_company->phone }}</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- single widget end -->
                </div>
            </div>
        </div>
        <!-- footer top area end -->
        <!-- footer bottom area start -->
        <div class="footer-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-bottom-content">
                            <div class="footer-copyright">
                                <p>&copy; {{ date('Y') }} <b>{{ $about_company->company_name }}</b> Copyright </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer bottom area end -->
    </footer>
    {{-- footer area end --}}

	{{-- all js include here --}}
    <script src="{{ asset('public_assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('public_assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('public_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public_assets/js/plugins.js') }}"></script>
    <script src="{{ asset('public_assets/js/ajax-mail.js') }}"></script>
    <script src="{{ asset('public_assets/js/main.js') }}"></script>
    <script src="{{ asset('public_assets/js/script.js') }}"></script>

    {{-- Ajax Request For Common Search Bar --}}
    <script>
        
        $('#search_input').keyup(function(){
            var searchSelectValue = $('#search_select').val();
            var searchInputValu = $(this).val();
            var searchOutputPlace = "";

            if(searchInputValu.length > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/search-product",
                    data: {
                        'category': searchSelectValue,
                        'search_value':searchInputValu,
                    },
                    dataType:'json',
                    success: function (data) {
                        if(data.length > 0) {
                            Object.keys(data).forEach(function(item){
                                searchOutputPlace += `<div class="search_single_item mb-2">
                                           <a href="/product-details/${data[item].product_code}">
                                               <div class="single_item_details d-flex align-items-center">
                                                    <div class="img_box">
                                                        <img src="/dashboard_assets/images/thumbnail/125x125/${data[item].thumbnail}" alt="">
                                                    </div>
                                                    <div class="ml-3 w-50">
                                                        <h6 class="title">${data[item].title}</h6>
                                                        <span class="category text-muted font-weight-bold">${data[item].name}</span>
                                                    </div>
                                                    <div class="text-right" style="flex-grow: 1;">
                                                        <span class="price p-2">${data[item].price} (BDT)</span>
                                                    </div>
                                               </div>
                                           </a> 
                                        </div>`;
                            });
                            $('.search_result_content').html(searchOutputPlace);
                        }else {
                            $('.search_result_content').html("<div>No Data Found</div>");
                        }
                    },

                })
            }

        })
    </script>

    {{-- Page Script --}}
    @yield('js_script')
</body>
</html>