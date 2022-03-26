@extends('layouts.backend_master')
@section('backend_content')
    @push('style')
        <!-- Datatable CSS Stars-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
        <!-- Datatable CSS Ends-->
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

                                <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary">
                                    Create <i class="fa fa-thumbs-o-down"></i></a>

                                <div class="table-responsive">

                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($category as $key=> $item)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $item->name }} </td>
                                                <td> <img src="{{ asset('upload/images/category/' . $item->image) }}" alt=""
                                                    width="50px" height="50px"> </td>

                                                <td>
                                                <!-- Status Starts -->
                                                    @if ($item->status == 1)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                <!-- Status Ends -->
                                                </td>

                                                <td> {{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y')}} </td>
                                                
                                                <td> {{ \Carbon\Carbon::parse($item->upated_at)->format('d M, Y')}} </td>

                                                <td>
                                                    <a href="{{ route('category.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                                        Edit <i class="fa fa-thumbs-o-down"></i></a>

                                                    <!-- Destroy Starts -->
                                                    <a class="btn btn-sm btn-danger" href="{{ route('category.destroy', $item->id) }}"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                        Delete <i class="fa fa-trash"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('category.destroy', $item->id) }}" method="POST" style="display: none;">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
                                                    <!-- Destroy Ends -->

                                                
                                                    <!-- status update starts -->
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('category.status', $item->id) }}" class="btn btn-sm btn-warning">
                                                            inactive <i class="fa fa-thumbs-o-down"></i></a>
                                                    @else
                                                        <a href="{{ route('category.status', $item->id) }}" class="btn btn-sm btn-success">
                                                            active <i class="fa fa-thumbs-o-up"></i></a>'
                                                    @endif
                                                    <!-- status update ends -->

                                                </td>
                                            </tr>
                                            @endforeach
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
                                        <!-- Datatable JS Stars -->
                                        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                                        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                                        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

                                        <script>
                                            $(document).ready(function() {
                                                $('#example').DataTable();
                                            });
                                        </script>
                                        <!-- Datatable JS Ends -->
                                    @endpush
                                @endsection
