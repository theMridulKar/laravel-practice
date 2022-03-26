@extends('layouts.backend_master')
@section('backend_content')

@push('style')
<!-- Yajra Box DataTable CSS Starts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<!-- Yajra Box DataTable CSS Ends -->
@endpush

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-header start -->
                    <div class="page-header card">

                        <ul class="breadcrumb-title b-t-default p-t-10">
                            <li class="breadcrumb-item">
                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Basic Componenets</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Bootstrap Basic Tables</a>
                            </li>
                        </ul>

                    </div>
                    <!-- Page-header end -->

                    <!-- Page-body start -->
                    <div class="page-body">
                        <!-- Basic table card start -->
                        <div class="card">
                            <div class="card-block table-border-style">

                                <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">
                                    Create <i class="fa fa-thumbs-o-down"></i></a>

                                <div class="table-responsive">

                                    <table id="datatable-product" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Category</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Code</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('script')
    <!-- Yajra Box DataTable JS Starts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                // get data from database table and display with html table with pagination
                $('#datatable-product').DataTable({
                    // selecting the table with id="datatable-product
                    serverSide: true,
                    ajax: "{{ route('product.data.table') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'category_id',
                            name: 'category_id'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            orderable: false
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: false
                        },
                        {
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },
                    ]
                });
            });
        </script>
        <!-- Yajra Box DataTable JS Ends -->
    @endpush
@endsection
