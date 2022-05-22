@php
    $user_identity = "";
    if(Auth::user()->username !== null){
        $user_identity = Auth::user()->username;
    }else{
        $user_identity = Crypt::encrypt(Auth::user()->id);
    }
@endphp
<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->

    <!-- plugin css file  -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/plugin/datatables/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard_assets/plugin/datatables/dataTables.bootstrap5.min.css') }}">

    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/ebazar.style.min.css') }}">

    <style>
        .h-right .user-profile .dropdown-menu .card.w280{
            width: auto;
        }
        .header .container-xxl {
            justify-content: right !important;
        }
    </style>

    @yield('css')
</head>
<body>
    <div id="ebazar-layout" class="theme-blue">
        <!-- sidebar -->
        <div class="sidebar px-4 py-4 py-md-4 me-0">
            <div class="d-flex flex-column h-100">
                <a href="{{ route('home') }}" class="mb-0 brand-icon">
                    <span class="logo-icon">
                        <i class="bi bi-bag-check-fill fs-4"></i>
                    </span>
                    <span class="logo-text">Zaman's Laptop</span>
                </a>
                <!-- Menu: main ul -->
                <ul class="menu-list flex-grow-1 mt-3">
                    <li><a class="m-link" href="index.html"><i class="icofont-home fs-5"></i> <span>Dashboard</span></a></li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#home-page" href="#">
                            <i class="icofont-truck-loaded fs-5"></i> <span>Home Page</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                            <!-- Menu: Sub menu ul -->
                            <ul class="sub-menu collapse" id="home-page">
                                <li><a class="ms-link" href="{{ route('slider.contents') }}">Slider Contents</a></li>
                                <li><a class="ms-link" href="{{ route('promotional.banners') }}">Promotional banners</a></li>
                            </ul>
                    </li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-product" href="#">
                            <i class="icofont-truck-loaded fs-5"></i> <span>Products</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                            <!-- Menu: Sub menu ul -->
                            <ul class="sub-menu collapse" id="menu-product">
                                <li><a class="ms-link" href="{{ route('product.list') }}">Product List</a></li>
                                <li><a class="ms-link" href="{{ route('product.add_from') }}">Product Add</a></li>
                            </ul>
                    </li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#categories" href="#">
                            <i class="icofont-chart-flow fs-5"></i> <span>Categories</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                            <!-- Menu: Sub menu ul -->
                            <ul class="sub-menu collapse" id="categories">
                                <li><a class="ms-link" href="{{ route('category.list') }}">Categories List</a></li>
                                <li><a class="ms-link" href="{{ route('category.add_form') }}">Categories Add</a></li>
                            </ul>
                    </li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#customers-info" href="#">
                        <i class="icofont-funky-man fs-5"></i> <span>Customers</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse" id="customers-info">
                            <li><a class="ms-link" href="{{ route('subscribers.list') }}">Subscribers List</a></li>
                            <li><a class="ms-link" href="{{ route('customer_message') }}">Messages</a></li>
                        </ul>
                    </li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-inventory" href="#">
                        <i class="icofont-chart-histogram fs-5"></i> <span>Inventory</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse" id="menu-inventory">
                            <li><a class="ms-link" href="{{ route('inventory.list') }}">Inventory List</a></li>
                            <li><a class="ms-link" href="{{ route('stock.list') }}">Stock List</a></li>
                        </ul>
                    </li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#about_us" href="#">
                        <i class="icofont-code-alt fs-5"></i> <span>About Us</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse" id="about_us">
                            <li><a class="ms-link" href="{{ route('about_us') }}">About us</a></li>
                            <li><a class="ms-link" href="{{ route('about_us.gallery') }}">Gellary</a></li>
                        </ul>
                    </li>

                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#business" href="#">
                        <i class="icofont-code-alt fs-5"></i> <span>Business</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse" id="business">
                            <li><a class="ms-link" href="{{ route('business.profile') }}">Business Profile</a></li>
                            <li><a class="ms-link" href="{{ route('business.brands') }}">Brands</a></li>
                        </ul>
                    </li>
                    
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#page" href="#">
                        <i class="icofont-page fs-5"></i> <span>Other Pages</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse" id="page">
                            <li><a class="ms-link" href="{{ route('user.profile', $user_identity) }}">Profile Page</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- Menu: menu collepce btn -->
                <button type="button" class="btn btn-link sidebar-mini-btn text-light">
                    <span class="ms-2"><i class="icofont-bubble-right"></i></span>
                </button>
            </div>
        </div>

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
            <div class="header">
                <nav class="navbar py-4">
                    <div class="container-xxl">

                        <!-- header rightbar icon -->
                        <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
                            <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center zindex-popover">
                                <div class="u-info me-2">
                                    <p class="mb-0 text-end line-height-sm "><span class="font-weight-bold">{{ Auth::user()->name }}</span></p>
                                    <small></small>
                                </div>
                                <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                                    <img class="avatar lg rounded-circle img-thumbnail" src="{{ asset('/dashboard_assets/images/user') }}/{{ Auth::user()->profile_image }}" alt="profile" style="object-fit:cover">
                                </a>
                                <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
                                    <div class="card border-0 w280">
                                        <div class="card-body pb-0">
                                            <div class="d-flex py-1">
                                                <img class="avatar rounded-circle" src="{{ asset('/dashboard_assets/images/user') }}/{{ Auth::user()->profile_image }}" alt="profile" style="object-fit:cover">
                                                <div class="flex-fill ms-3">
                                                    <p class="mb-0"><span class="font-weight-bold">{{ Auth::user()->name }}</span></p>
                                                    <small class="">{{ Auth::user()->email }}</small>
                                                </div>
                                            </div>
                                            
                                            <div><hr class="dropdown-divider border-dark"></div>
                                        </div>
                                        <div class="list-group m-2 ">
                                            <a href="{{ route('user.profile', $user_identity) }}" class="list-group-item list-group-item-action border-0 "><i class="icofont-ui-user fs-5 me-3"></i>Profile Page</a>
                                            <a href="order-invoices.html" class="list-group-item list-group-item-action border-0 "><i class="icofont-file-text fs-5 me-3"></i>Order Invoices</a>

                                            <a href="{{ route('logout') }}"onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action border-0"><i class="icofont-logout fs-5 me-3"></i>Signout</a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- menu toggler -->
                        <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
                            <span class="fa fa-bars"></span>
                        </button>
        
                    </div>
                </nav>
            </div>

            <!-- Body: Body -->
            @yield('content')
            
        </div>
    
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('/dashboard_assets/bundles/libscripts.bundle.js') }}"></script>

    <!-- Jquery Page Js -->
    <script src="{{ asset('/dashboard_assets/js/page/index.js') }}"></script>
    <script src="{{ asset('/dashboard_assets/js/template.js') }}"></script>

    {{-- yeild for custom JS --}}
    @yield('js_script')
</body>

</html> 
