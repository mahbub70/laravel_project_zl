@extends('layouts.app')

@section('title')
    <title>About Us Gallery - Zaman's Laptop</title>
@endsection

@section('css')
    <style>
        .upload_btn:hover .icofont-swoosh-up:before {
            color: #0d6efd;
            transition: 0.4s;
        }

        .upload_btn {
            outline: none;
            border: none;
            background: transparent;
            border-radius: 10px;
            box-shadow: none !important;
        }

        .upload_btn i {
            padding: 0px;
            border: 4px solid #ddd;
            border-radius: 50px;
            font-size: 30px;
        }

        .image-upload {
            min-height: 170px;
            overflow: hidden;
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

        /* Banner */
        .single-banner .banner-delete-btn {
            transition: 0.3s;
        }

        .single-banner:hover .banner-delete-btn {
            opacity: 1 !important;
            visibility: visible !important;
        }
        
    </style>
@endsection

@section('content')
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Gallery</h3>
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

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="m-0 mt-2">Add Gallery Image</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('about_us_gallery.add') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="image-upload">
                                    <div class="single-item mb-2 text-center" id="upload_box">
                                        <button type="button" class="upload_btn btn border p-5">
                                            <i class="icofont-swoosh-up text-dark"></i>
                                        </button>
                                        <div class="mt-2">Upload Image</div>
                                        <div class="file d-none">
                                            <input type="file" name="image" accept="image/*" id="file_input">
                                        </div>
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
                <div class="col-md-8">
                    <div class="row">
                        @if(count($data) > 0)
                            @foreach ($data as $key=>$item)
                                <div class="single-banner col-md-6 col-sm-4 mb-3">
                                    <div class="card h-100">
                                        <div class="img_box p-3">
                                            <img class="card-img-top" src="{{ asset('dashboard_assets/images/about_us_gallery') }}/{{ $item->image }}" alt="Gallery Image {{ $key+1 }}" />
                                        </div>
                                        <div class="card-body">
                                            <div class="title-del-btn d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title">Gallery {{ $key+1 }}</h5>
                                                <a href="{{ route('about_us_gallery.delete',encrypt($item->id)) }}" class="btn btn-outline-secondary deleterow banner-delete-btn opacity-0 invisible"><i class="icofont-ui-delete text-danger"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else

                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection

@section('js_script')
    <script>
        $('.upload_btn').click(function(){
            $('#file_input').click();
        });
    </script>

    {{-- Script For Form Image --}}
    <script>
        var file_input = document.getElementById('file_input');
        var product_images_wrp = document.getElementById('product_images_wrp');
        var uploadBox = document.getElementById('upload_box');
        var imgAddBtn = document.getElementById('btns_wrp');
        var refreshBtn = document.getElementById('refresh_btn');

        refreshBtn.addEventListener('click',function(){
            uploadBox.classList.remove('d-none');
            product_images_wrp.innerHTML = "";
            imgAddBtn.classList.add('d-none');

        });


        file_input.addEventListener('change',function(){
            uploadBox.classList.add('d-none');
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
                    }
                }else{
                    product_images_wrp.previousElementSibling.classList.remove('d-none');
                }

            });
        });

    </script>
@endsection