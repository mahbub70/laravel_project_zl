@extends('layouts.app')

{{-- Title --}}
@section('title')
    <title>Category Add - Zaman's Laptop</title>
@endsection

@section('css')
    <style>
        .category_img_box{
            display: inline-block;
            margin-top: 15px;
            border: 1px solid #ddd;
            border-radius: 7px;
            padding: 5px;
        }
    </style>
@endsection

@section('content')
    <!-- Body: Body -->
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">{{ $view_info['title'] }}</h3>
                    </div>
                </div>
            </div> <!-- Row end  -->
            
            <div class="row g-3 mb-3">
                <div class="col-lg-8 m-auto mt-3">
                    {{--  Message From Controller--}}
                    @if (session('faild'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Faild!</strong> {{ session('faild') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {!! session('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card mb-3">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Basic information</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($data)?route($view_info['action_url'],encrypt($data->id)):route($view_info['action_url']) }}" method="post" enctype="multipart/form-data" id="category_add_form">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label  class="form-label">Category Name</label>
                                        <input type="text" class="form-control" name="name" @error('name') autofocus @enderror value="{{ isset($data)?old('name',$data->name):old('name') }}">
                                        @error('name')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Category Image (Optional)</label>
                                        <input type="file" class="form-control" name="image" id="file" accept="image/*">
                                        @error('image')
                                            <div class="alert alert-warning">{!! $message !!}</div>
                                        @enderror
                                        <div class="category_img_box" style="display: none">
                                            <canvas id="canvas" width="300"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <button type="submit" name="save" class="btn btn-primary py-2 px-5 text-uppercase btn-set-task w-sm-100">Save</button>
                                    </div>
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
    <script>
        $(".category_img_box").hide();
        $(".category_img_box #canvas").hide();
        var file_input = document.getElementById('file');

        file_input.addEventListener('change',function(){
            $(".category_img_box").fadeOut();
            if(file_input.files && file_input.files[0]){
                var reader = new FileReader();
                reader.readAsDataURL(file_input.files[0]);
                reader.onload = function(e){
                    const canvas = document.getElementById("canvas");
                    const ctx = canvas.getContext("2d");
                    const img = new Image();
                    img.src = e.target.result;

                    img.onload = function () {
                        canvas.height = canvas.width * (img.height / img.width);
                        const oc = document.createElement('canvas');
                        const octx = oc.getContext('2d');
                        oc.width = img.width * 0.75;
                        oc.height = img.height * 0.75;
                        octx.drawImage(img, 0, 0, oc.width, oc.height);
                        ctx.drawImage(oc, 0, 0, oc.width * 0.75, oc.height * 0.75, 0, 0, canvas.width, canvas.height);

                        $(".category_img_box").fadeIn(700);
                        $(".category_img_box #canvas").fadeIn(700);
                    }
                } 

            }
            
        })
    </script>
@endsection


