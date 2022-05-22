@extends('layouts.app')

@section('title')
    <title>Product Edit - Zaman's Laptop</title>
@endsection

@section('css')
    {{-- Description Editor CSS --}}
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/bundle.css') }}">
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
        input[type='checkbox']{
            min-width:16px;
            min-height:16px;
            margin-right: 8px;
        }
        .product_images .img_box button{
            transform: translate(50%,-50%) scale(0);
            transition: 0.3s;
        }
        .product_images .img_box:hover button{
            transform: translate(50%,-50%) scale(1);
        }
    </style>
@endsection

@section('content')
    <!-- Body: Body -->
    <div class="body d-flex py-3 mb-5">
        <div class="container-xxl">

            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Product Edit</h3>
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
            
            <div class="row g-3 mb-3 mt-3">
                <div class="col-xl-10 col-lg-10 m-auto">
                    <div class="card mb-3">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Basic information</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.edit',$data->product_code) }}" method="post" enctype="multipart/form-data" id="product_edit_form">
                                @csrf
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4">
                                        <div class="text-muted small">Category <span class="small-11 text-muted">(Not Editable.)</span></div>
                                        <strong>{{ $data->category->name }}</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <label  class="form-label" for="brand">Brand</label>
                                        <input type="text" class="form-control" name="brand" id="brand" placeholder="Enter Product Brand Name" @error('brand') autofocus @enderror value="{{ old('brand',$data->brand) }}">
                                        @error('brand')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                        @error('category_id')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label  class="form-label" for="model">Model</label>
                                        <input type="text" class="form-control" name="model" id="model" placeholder="Enter Product Model Number" @error('model') autofocus @enderror value="{{ old('model',$data->model) }}">
                                        @error('model')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label  class="form-label" for="title">Title</label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Product Title" @error('title') autofocus @enderror value="{{ old('title',$data->title) }}">
                                        @error('title')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label  class="form-label" for="color">Color (Optional) - <span class="small-11 text-muted">Multiple color seperated by comma (,).</span></label>
                                        <input type="text" class="form-control" name="color" id="color" placeholder="Enter Product Color" @error('color') autofocus @enderror value="{{ old('color',$data->color) }}">
                                        @error('color')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="description">Product Description</label>
                                        <div id="editor">
                                            @if (old('description'))
                                                {!! old('description') !!}
                                            @else
                                                {!! $data->description !!}
                                            @endif
                                        </div>
                                        <input type="hidden" name="description" id="description" placeholder="Enter Product Description" @error('description') autofocus @enderror>
                                        @error('description')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="price">Price (BDT)</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">৳</div>
                                            </div>
                                            <input type="number" class="form-control" placeholder="Enter Product Price" name="price" id="price" @error('price') autofocus @enderror value="{{ old('price',$data->price) }}">
                                        </div>
                                        @error('price')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label  class="form-label" for="image">Image (Maximum 5 Pcs)</label>
                                        <input type="file" class="form-control" name="image[]" id="images" multiple @error('image') autofocus @enderror>
                                        @error('image')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <p class="text-danger ps-3 d-none">Maximum 5 images (First 5 images will be selected)</p>
                                    <div class="product_images d-flex mt-3 justify-content-center flex-wrap" id="product_images_wrp">
                                        @php
                                            $images_array = json_decode($data->images, true);
                                        @endphp
                                        @foreach ($images_array as $key=>$image)
                                            <div class="img_box {{ $key }} position-relative">
                                                <img src="{{ asset('/dashboard_assets/images/product') }}/{{ $image }}" alt="Product Image" data-image="{{ $key }}" class="db_image">
                                                <button type="button" class="btn btn-danger position-absolute top-50 end-50 image_cross_btn"><i class="icofont-close text-white"></i></button>
                                            </div>
                                        @endforeach

                                        <div id="new_img" class="d-flex justify-content-center flex-wrap"></div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <input type="checkbox" name="phone" id="phone" checked>
                                        <span for="phone" class="font-weight-bold">01752986720</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="optional_phone" class="form-label">Another Phone (Optional)</label>
                                        <input type="text" name="optional_phone" id="optional_phone" placeholder="Optional Phone" class="form-control" @error('optional_phone') autofocus @enderror value="{{ old('optional_phone',$data->optional_phone) }}">
                                        @error('optional_phone')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="discount" class="form-label">Discount-% (Optional)</label>
                                        <input type="number" name="discount" id="discount" placeholder="Discount" class="form-control" @error('discount') autofocus @enderror value="{{ old('discount',$data->discount) }}">
                                        @error('discount')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="position" class="form-label">Change Position</label>
                                        <select name="position" id="position" class="form-control">
                                            <option selected disabled>Choose One</option>
                                            <option value="1">Hot Collection</option>
                                        </select>
                                        @error('position')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-auto mt-4">
                                    <button type="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase mt-2">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- Row end  --> 
            
        </div>
    </div>
@endsection

@section('js_script')
    {{-- Initialize Quill editor --}}
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'direction': 'rtl' }],                         // text direction

            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'align': [] }],

            ['clean']                                         // remove formatting button
        ];
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar : toolbarOptions
            }
        });

    </script>

    {{-- Image --}}
    <script>
        var deleted_images = [];
        var imgCrossBtn = document.querySelectorAll('.image_cross_btn');
        var img_box_count = document.querySelectorAll('#product_images_wrp .img_box').length;
        var loop = 5 - img_box_count;
        imgCrossBtn.forEach(function(item){
            item.addEventListener('click',function(){
                var img_info = item.parentNode.querySelector('img.db_image').getAttribute('data-image');
                deleted_images.push(img_info);
                item.parentNode.remove();
                var img_box_count = document.querySelectorAll('#product_images_wrp .img_box').length;
                loop = 5 - img_box_count;
            });
        });
        
        var file_input = document.getElementById('images');
        var product_images_wrp = document.getElementById('new_img');
        var old_image_available = 0;

        file_input.addEventListener('change',function(){
            old_image_available = 0;
            var all_image_file = file_input.files;
            var count_old_image =  product_images_wrp.querySelectorAll('div.img_box img');
            count_old_image.forEach(function(old_single_img){
                if(old_single_img.hasAttribute('data-image')){
                    old_image_available++;
                }else{
                    old_single_img.parentNode.remove();
                }
            })

            Object.keys(all_image_file).forEach(function(item){

                if(item < loop){
                    var fileReader = new FileReader();
                    fileReader.readAsDataURL(all_image_file[item]);

                    fileReader.onload = function(e){
                        var img = new Image();
                        img.src = e.target.result;
                        product_images_wrp.innerHTML += `<div class="img_box"><img src="${e.target.result}" alt="Product Image"></div>`;
                    }
                }else{
                    product_images_wrp.parentElement.previousElementSibling.classList.remove('d-none');
                    
                }
            });

        });
    </script>

    {{-- Form submit after do some process --}}
    <script>
        var form = document.getElementById('product_edit_form');
        form.addEventListener('submit',function(e){
            e.preventDefault();

            // Populate hidden form on submit
            var description = document.querySelector('input[name=description]');
            description.value = $('#editor .ql-editor').html();

            var create_input = document.createElement('input');
            create_input.setAttribute('type','hidden');
            create_input.name = 'deleted_images';
            create_input.value = deleted_images;
            form.appendChild(create_input);

            e.currentTarget.submit();
        });
    </script>
@endsection