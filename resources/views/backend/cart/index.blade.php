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

                                <form action="{{ route('add.to.cart') }}" method="POST">
                                    @csrf
                                    <!-- Product Selection Starts -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Select Product</label>
                                        <div class="col-sm-10">
                                            <select name="product_id" class="form-control">
                                                @foreach ($product as $item)
                                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Product Selection Ends -->
                                    <button type="submit" class="mb-4 btn btn-sm btn-primary">Search</button>
                                </form>

                                <div class="table-responsive">

                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        @php
                                            $neat_quantity = 0;
                                            $neat_price = 0;
                                            $key = 1;
                                        @endphp

                                        <tbody>
                                            @foreach ($cart as $item)
                                                <tr>
                                                    <td> {{ $key ++ }} </td>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>{{ $item['price'] }}</td>
                                                    <td>{{ $item['price'] * $item['quantity'] }}</td>
                                                    
                                                    <td>
                                                        <a class="btn btn-sm btn-danger" href="{{ route('cart.from.cart', $item['product_id']) }}">Remove</a>
                                                    </td>
                                                </tr>

                                                @php
                                                    $neat_quantity += $item['quantity'];
                                                    $neat_price += $item['price'] * $item['quantity'];
                                                @endphp
                                            @endforeach


                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><b>Total:</b> <br> {{ $neat_quantity }}</td>
                                                <td></td>
                                                <td><b>Total:</b> <br> {{ $neat_price }}</td>
                                            </tr>
                                        </tfoot>
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
