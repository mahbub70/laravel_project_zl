@extends('layouts.app')

@section('title')
    <title>Category List - Zaman's Laptop</title>
@endsection

@section('css')
    <style>
        .table_img_box{
            width:100px;
            height: auto;
            object-fit: cover;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 7px;
        }
        .table_img_box img{
            width: 100%;
            height: 100%;
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
                        <h3 class="fw-bold mb-0">Categorie List</h3>
                        <a href="{{ route('category.add_form') }}" class="btn btn-primary py-2 px-5 btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i> Add Categories</a>
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
            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @if (count($data) > 0)
                                <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SL NO</th>
                                            <th>Categorie</th>
                                            <th>Created By</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key=>$item)
                                            <tr>
                                                <td><strong>{{ $key + 1 }}</strong></td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>
                                                    <div class="table_img_box">
                                                        <img src="{{ asset('dashboard_assets/images/category') }}/{{ $item->image }}" alt="" >
                                                    </div>
                                                </td>
                                                <td>{{ ($item->created_at != null)?$item->created_at->diffForHumans():'' }}</td>
                                                <td><span class="badge bg-success">Published</span></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <a href="{{ route('category.edit_form',encrypt($item->id)) }}" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                                                        <a href="{{ route('category.delete',encrypt($item->id)) }}" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No data found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

