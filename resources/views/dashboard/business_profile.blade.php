@extends('layouts.app')

@section('title')
    <title>Business Profile - Zaman's Laptop</title>
@endsection

@section('css')
    <style>
        .social_item i {
            font-size: 22px;
        }

        .product_images{
            gap: 10px;
        }

        .product_images .img_box{
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 7px;
            margin-bottom: 15px;
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
        }

        .product_images .img_box img{
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .profile-block {
            width: 66%;
        }

        .profile-block a img {
            width: 100% !important;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Business Profile</h3>
                </div>
            </div>
        </div> <!-- Row end  -->
        {{-- Message From Controller --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('faild'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {!! session('faild') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row g-3">
            <div class="col-xl-4 col-lg-5 col-md-12">
                {{-- Profile Section --}}
                <div class="card profile-card flex-column mb-3">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">Profile</h6>
                    </div>
                    @if($data != null)
                        <div class="card-body d-flex profile-fulldeatil flex-column">
                            <div class="profile-block text-center mx-auto">
                                <a href="#">
                                    <img src="{{ asset('dashboard_assets/images/logo') }}/{{ $data->image }}" alt="" class="avatar xl rounded img-thumbnail shadow-sm">
                                </a>
                                <button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" title="Upload Profile Image" id="upload_btn"><i class="icofont-upload-alt"></i></button>
                                {{-- <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                    <span class="text-muted small">Admin ID : PXL-0001</span>
                                </div> --}}
                            </div>
                            <div class="profile-info w-100">
                                <h6  class="mb-0 mt-2  fw-bold d-block fs-6 text-center">{{ $data->company_name }}</h6>
                                {{-- <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">24 years, California</span> --}}
                                <div class="row g-2 pt-2">
                                    @if ($data->phone != null)
                                        <div class="col-xl-12">
                                            <div class="d-flex align-items-center">
                                                <i class="icofont-ui-touch-phone"></i>
                                                <span class="ms-2">{{ $data->phone }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-xl-12">
                                        @if ($data->email != null)
                                            <div class="d-flex align-items-center">
                                                <i class="icofont-email"></i>
                                                <span class="ms-2">{{ $data->email }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-xl-12">
                                        @if ($data->address)
                                            <div class="d-flex align-items-center">
                                                <i class="icofont-address-book"></i>
                                                <span class="ms-2">{{ $data->address }}</span>
                                            </div>
                                        @endif
                                    </div> 
                                    <div class="col-xl-12">
                                        @if ($data->website != null)
                                            <div class="d-flex align-items-center">
                                                <i class="icofont-ui-browser"></i>
                                                <span class="ms-2">{{ $data->website }}</span>
                                            </div>
                                        @endif
                                    </div> 
                                </div>
                                {{-- Social Links --}}
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-around align-items-center mt-3">
                                        @if($data->facebook_link != null)
                                            <div class="social_item">
                                                <a href="{{ url($data->facebook_link) }}" target="_blank" class="btn btn-outline-secondary"><i class="icofont-facebook text-primary"></i></a>
                                            </div>
                                        @endif
                                        @if ($data->twitter_link != null)
                                            <div class="social_item">
                                                <a href="{{ url($data->twitter_link) }}" target="_blank" class="btn btn-outline-secondary"><i class="icofont-twitter text-primary"></i></a>
                                            </div>
                                        @endif
                                        @if ($data->linkedin_link)
                                            <div class="social_item">
                                                <a href="{{ url($data->linkedin_link) }}" target="_blank" class="btn btn-outline-secondary"><i class="icofont-linkedin text-primary"></i></a>
                                            </div>
                                        @endif
                                        @if ($data->instagram_link)
                                            <div class="social_item">
                                                <a href="{{ url($data->instagram) }}" target="_blank" class="btn btn-outline-secondary"><i class="icofont-instagram text-primary"></i></a>
                                            </div>
                                        @endif
                                        @if ($data->youtube_link)
                                            <div class="social_item">
                                                <a href="{{ url($data->youtube_link) }}" target="_blank" class="btn btn-outline-secondary"><i class="icofont-youtube text-primary"></i></a>
                                            </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-xl-8 col-lg-7 col-md-12">
                <div class="card mb-3">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">Profile Settings</h6>
                    </div>
                    <div class="card-body">
                        <form class="row g-4" method="post" action="{{ route('business_profile.add') }}" id="business_profile_form">
                            @csrf
                            @method('PUT')
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Company Name</label>
                                    <input class="form-control"  type="text" id="company_name" placeholder="Company Name" @error('company_name') autofocus @enderror value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <div class="alert alert-warning">{!! $message !!}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input class="form-control" type="text" id="phone" placeholder="Phone Number" @error('phone') autofocus @enderror value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="alert alert-warning">{!! $message !!}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control"  aria-label="With textarea" id="address" placeholder="Please enter your address..." @error('address') autofocus @enderror>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="alert alert-warning">{!! $message !!}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label">Website Url</label>
                                <div class="input-group">
                                    <span class="input-group-text">http://</span>
                                    <input type="text" class="form-control" id="website" placeholder="Website" @error('website') autofocus @enderror value="{{ old('website') }}">
                                    @error('website')
                                        <div class="alert alert-warning">{!! $message !!}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Eamil Address</label>
                                    <input class="form-control" type="email" id="email" placeholder="Email Address" @error('email') autofocus @enderror value="{{ old('email') }}">
                                    @error('email')
                                        <div class="alert alert-warning">{!! $message !!}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                <h6 class="mb-0 fw-bold ">Social Links</h6>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Facebook</label>
                                <div class="input-group">
                                    <span class="input-group-text">Facebook</span>
                                    <input type="text" class="form-control" id="facebook_link" placeholder="Facebook" @error('facebook') autofocus @enderror value="{{ old('facebook') }}">
                                    @error('facebook')
                                        <div class="alert alert-warning">{!! $message !!}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Twitter</label>
                                <div class="input-group">
                                    <span class="input-group-text">Twitter</span>
                                    <input type="text" class="form-control" id="twitter_link" placeholder="Twitter" @error('twitter') autofocus @enderror value="{{ old('twitter') }}">
                                    @error('twitter')
                                        <div class="alert alert-warning">{!! $message !!}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Youtube</label>
                                <div class="input-group">
                                    <span class="input-group-text">Youtube</span>
                                    <input type="text" class="form-control" id="youtube_link" placeholder="Youtube" @error('youtube') autofocus @enderror value="{{ old('youtube') }}">
                                    @error('twitter')
                                        <div class="alert alert-warning">{!! $message !!}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary text-uppercase px-5">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Logo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('logo.add') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="image-upload">
                            <div class="file d-none">
                                <input type="file" name="image" accept="image/*" id="file_input">
                            </div>
                            <div class="image-show" id="image_show_box">
                                <p class="text-danger d-none">Maximum 1 image</p>
                                <div class="product_images d-flex me-2 justify-content-center flex-wrap" id="product_images_wrp"></div>
                            </div>
                        </div>
                        @error('image')
                            <div class="alert alert-warning mt-1">{!! $message !!}</div>
                        @enderror
                        <div class="d-flex justify-content-between d-none" id="btns_wrp">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-outline-secondary" id="refresh_btn"><i class="icofont-refresh"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('js_script')
    <script>
        // Add name attribute by changing input field values
        var form_input = document.querySelectorAll('#business_profile_form .form-control');
        form_input.forEach(function(item){
            item.addEventListener('change',function(){
                item.setAttribute('name',this.getAttribute('id'));
            })
        })

        // Get old input values from Laravel validation rule.
        var all_old_values = {};
        var all_old_values = @json(session()->getOldInput());

        // Add name if have errors in form validation.
        Object.keys(all_old_values).forEach(function(item){
            form_input.forEach(function(input_item){
                if(item == input_item.getAttribute('id')){
                    input_item.setAttribute('name',item);
                }
            })
        });
    </script>

    {{-- Script For Form Image --}}
    <script>
        $('#upload_btn').click(function(){
            $('#file_input').click();
        });

        @if ($errors->any())
            new bootstrap.Modal(document.getElementById('exampleModal')).show();
        @endif

        var file_input = document.getElementById('file_input');
        var product_images_wrp = document.getElementById('product_images_wrp');
        var imgAddBtn = document.getElementById('btns_wrp');
        var refreshBtn = document.getElementById('refresh_btn');

        refreshBtn.addEventListener('click',function(){
            product_images_wrp.innerHTML = "";
            imgAddBtn.classList.add('d-none');
            $('.modal .btn-close').click();

        });


        file_input.addEventListener('change',function(){
            var all_image_file = file_input.files;
            product_images_wrp.innerHTML = "";

            Object.keys(all_image_file).forEach(function(item){
                if(item < 1){
                    var fileReader = new FileReader();
                    fileReader.readAsDataURL(all_image_file[item]);

                    fileReader.onload = function(e){
                        var img = new Image();
                        img.src = e.target.result;
                        product_images_wrp.innerHTML += `<div class="img_box"><img src="${e.target.result}" alt="Product Image"></div>`;
                        imgAddBtn.classList.remove('d-none');
                        new bootstrap.Modal(document.getElementById('exampleModal')).show();
                    }
                }else{
                    product_images_wrp.previousElementSibling.classList.remove('d-none');
                }

            });
        });

    </script>
@endsection