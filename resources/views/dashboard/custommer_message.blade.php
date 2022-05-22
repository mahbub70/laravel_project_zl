@extends('layouts.app')

@section('title')
    <title>Customer Message - Zaman's Laptop</title>
@endsection

@section('css')
    
@endsection

@section('content')
    <!-- Body: Body -->
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Custommer Messages</h3>
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
            
            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @if (count($data) != "")
                                <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SL NO</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Message</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key=>$item)
                                            <tr>
                                                <td><strong>{{ $key+1 }}</strong></td>
                                                <td><strong>{{ $item->name }}</strong></td>
                                                <td>{{ $item->email_address }}</td>
                                                <td>{{ $item->phone}}</td>
                                                <td>
                                                    {{ $item->message }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('custommer_message.delete',$item->id) }}" class="btn btn-outline-secondary"><i class="icofont-delete text-danger"></i></a>
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