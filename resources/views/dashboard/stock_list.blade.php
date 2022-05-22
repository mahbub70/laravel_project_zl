@extends('layouts.app')

@section('title')
    <title>Stock List - Zaman's Laptop</title>
@endsection

@section('css')
    
@endsection

@section('content')
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Stock List</h3>
                    </div>
                </div>
            </div> <!-- Row end  -->
            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @if (count($data) != "")
                                <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SL NO</th>
                                            <th>Product Code</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Discount</th>
                                            <th>Discount Price</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key=>$item)
                                            <tr>
                                                <td><strong>{{ $key+1 }}</strong></td>
                                                <td><strong>{{ $item->product_code }}</strong></td>
                                                <td>
                                                    <img src="{{ asset('/dashboard_assets/images/thumbnail/125x125') }}/{{ $item->thumbnail }}" class="avatar lg rounded me-2" alt="Product-Image">
                                                </td>
                                                <td><a href="{{ route('product.details', $item->product_code) }}">{{ Str::limit($item->title, 15 , '...') }}</a></td>
                                                <td>
                                                    {{ $item->category->name }}
                                                </td>
                                                <td>{{ $item->discount . "%" }}</td>
                                                <td>
                                                    {{ $item->price - (($item->price * $item->discount)/100) }}
                                                </td>
                                                <td>{{ $item->price }}</td>
                                                <td><span class="badge {{ ($item->status != 1)?'bg-danger':'bg-info' }}">{{ ($item->status != 1)?'Sold':'Available' }}</span></td>
                                                <td>
                                                    <a href="{{ route('product.edit_form',$item->product_code) }}" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    {{-- Link Plug In --}}
    <script src="{{ asset('/dashboard_assets/bundles/dataTables.bundle.js') }}"></script>

    <script>
        
        $('#myDataTable')
        .addClass( 'nowrap' )
        .dataTable( {
            responsive: true,
            columnDefs: [
                { targets: [-1, -3], className: 'dt-body-right' }
            ],
            aLengthMenu: [10, 25, 50],
        });

    </script>
@endsection