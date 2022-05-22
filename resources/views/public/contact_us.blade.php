@extends('public.layouts.app')

@section('title')
    <title>Contact Us - Zaman's Laptop</title>
@endsection

@section('css')
    
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
                                <li class="breadcrumb-item active" aria-current="page">Contact</li>
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
            <div class="row">
                <div class="col-12">
                    <div class="contact2-title text-center mb-65">
                        <h2>contact us</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <h3>address street</h3>
                        <p>{{ $about_company->address }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <h3>number phone</h3>
                        <p>{{ $about_company->phone }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <h3>address email</h3>
                        <p>{{ $about_company->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- contact form two -->
    <div class="contact-two-area pt-60 pb-70">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="contact2-title text-center mb-60">
                            <h2>tell us your project</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="contact-message">
                            <form action="{{ route('customer.message') }}" method="post" class="contact-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="name" placeholder="Name *" type="text" value="{{ old('name') }}" @error('name') autofocus @enderror>  
                                        @error('name')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror 
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="phone" placeholder="Phone *" type="text" value="{{ old('phone') }}" @error('phone') autofocus @enderror>
                                        @error('phone')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror    
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="email_address" placeholder="Email *" type="text" value="{{ old('email_address') }}" @error('email_address') autofocus @enderror>
                                        @error('email_address')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror    
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="subject" placeholder="Subject *" type="text" value="{{ old('subject') }}" @error('subject') autofocus @enderror >
                                        @error('subject')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror      
                                    </div>
                                <div class="col-12">
                                        <div class="contact2-textarea text-center">
                                            <textarea placeholder="Message *" name="message"  class="form-control2" @error('Message') autofocus @enderror @if (session('Csuccess')) autofocus @endif>{{ old('message') }}</textarea>
                                            @error('message')
                                                <div class="alert alert-warning">{!! $message !!}</div>
                                            @enderror     
                                        </div>   
                                        <div class="contact-btn text-center">
                                            <button class="btn btn-secondary" type="submit" autofocus>Send Message</button> 
                                        </div> 
                                    </div>
                                    
                                    {{--  Message From Controller--}}
                                    @if (session('Cfaild'))
                                        <div class="alert alert-danger alert-dismissible fade show" style="margin: 15px auto" role="alert">
                                            <strong>Faild!</strong> {!! session('Cfaild') !!}
                                            <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (session('Csuccess'))
                                        <div class="alert alert-success alert-dismissible fade show" style="margin: 15px auto" role="alert">
                                            <strong>Success!</strong> {!! session('Csuccess') !!}
                                            <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>
                            </form>    
                        </div> 
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    
@endsection