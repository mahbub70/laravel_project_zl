@extends('layouts.app')

@section('title')
    <title>Slider Contents - Zaman's Laptop</title>
@endsection

@section('css')
    <style>
        .product_images{
            gap: 10px;
        }
        .product_images .img_box{
            max-width: 150px;
            height: auto;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 7px;
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
        }
        .product_images .img_box img{
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* Slider */
        .single-slider .slider-delete-btn {
            transition: 0.3s;
        }

        .single-slider:hover .slider-delete-btn {
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
                    <h3 class="fw-bold mb-0">Slider Contents</h3>
                    <div class="btn-set-task w-sm-100">
                        <button id="add_slider_btn" class="btn btn-primary py-2 px-5 w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i> Add Slider</button>
                    </div>
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
            <div class="col-12 border border-primary" id="add_slider_form" @if($errors->any()) style="display: block !important" @endif style="display: none">
                <div class="slider-add-form-wrap py-2">
                    <form action="{{ route('slider.add') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="slider-add-contents d-flex align-items-center justify-content-between" style="flex-flow: row wrap;">
                            <div class="item-wrp mb-2 w-100">
                                <label for="sliderText" class="form-label">Slider Text (Optional)</label>
                                <textarea name="slider_text" id="sliderText" placeholder="Write about your slider" class="form-control"></textarea>
                                @error('slider_text')
                                    <div class="alert alert-warning mt-1">{!! $message !!}</div>
                                @enderror
                            </div>
                            <div class="item-wrp mb-2 pe-4 w-50">
                                <label for="sliderButton" class="form-label">Button Text (Optional)</label>
                                <input type="text" name="button_text" class="form-control" id="sliderButton" placeholder="Please enter your slider button text">
                                @error('button_text')
                                    <div class="alert alert-warning mt-1">{!! $message !!}</div>
                                @enderror
                            </div>
                            <div class="item-wrp mb-2 pe-4 w-50">
                                <label for="sliderButtonLink" class="form-label">Button Link (Optional)</label>
                                <input type="text" name="button_link" class="form-control" id="sliderButtonLink" placeholder="Please enter your slider button link">
                                @error('button_link')
                                    <div class="alert alert-warning mt-1">{!! $message !!}</div>
                                @enderror
                            </div>
                            <div class="item-wrp mb-2 pe-4">
                                <label for="sliderImage" class="form-label">Slider Image</label>
                                <input type="file" name="image" accept="image/*" class="form-control" id="images">
                                @error('image')
                                    <div class="alert alert-warning mt-1">{!! $message !!}</div>
                                @enderror
                            </div>
                            <div class="item-wrp mb-2">
                                <p class="text-danger d-none">Maximum 1 image</p>
                                <div class="product_images d-flex me-2 justify-content-center flex-wrap" id="product_images_wrp"></div>
                            </div>
                            <div class="item-wrp text-end">
                                <button type="submit" class="btn btn-primary py-2 px-5 w-sm-100">Add Slider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            @if (count($data) > 0)
                @foreach ($data as $key=>$item)
                    <div class="single-slider col-xxl-3 col-md-4 col-sm-6 mb-3">
                        <div class="card">
                            <div class="img_box p-3">
                                <img class="card-img-top" src="{{asset('dashboard_assets/images/slider')}}/{{ $item->image }}" alt="Slider Image {{ $key+1 }}" />
                            </div>
                            <div class="card-body">
                                <div class="title-del-btn d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title">Slider {{ $key+1 }}</h5>
                                    <a href="{{ route('slider.delete',encrypt($item->id)) }}" class="btn btn-outline-secondary deleterow slider-delete-btn opacity-0 invisible"><i class="icofont-ui-delete text-danger"></i></a>
                                </div>
                                <p class="card-text">{{ $item->slider_text }}</p>
                                @if ($item->button_text != null)
                                    <a href="{{ $item->button_link }}" class="btn btn-primary">{{ $item->button_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div >No Data Available</div>
            @endif
        </div>
        
    </div>
</div>
@endsection

@section('js_script')
    <script>
        $('#add_slider_btn').click(function(){
            $('#add_slider_form').slideToggle();
        });
    </script>

    {{-- Script For Form Image --}}
    <script>
        var file_input = document.getElementById('images');
        var product_images_wrp = document.getElementById('product_images_wrp');

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
                    }
                }else{
                    product_images_wrp.previousElementSibling.classList.remove('d-none');
                }

            });
        });

    </script>
@endsection