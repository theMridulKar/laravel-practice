@extends('layouts.backend_master')
@section('backend_content')
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
                            <li class="breadcrumb-item"><a href="#!">Category</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Edit</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Page-header end -->

                    <!-- Page body start -->
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Basic Form Inputs card start -->
                                <div class="card">
                                    
                                    <div class="card-header">
                                        <div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
                                        <div class="card-header-right">
                                            <i class="icofont icofont-spinner-alt-5"></i>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h4 class="sub-title">Category</h4>
                                        <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <!-- Name Starts -->
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input id="name" name="name" value="{{ $category->name }}" type="text"
                                                        class="@error('name') is-invalid @enderror form-control"
                                                        placeholder="Type your Category name">

                                                        @error('name')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                </div>
                                            </div>
                                            <!-- Name Ends -->

                                            <!-- Image Starts -->
                                            <div class="form-group row">
                                                <label for="image" class="col-sm-2 col-form-label">Image</label>
                                                <div class="col-sm-10">
                                                    <!-- Old Image Starts -->
                                                    <img src="{{ asset('upload/images/category/' . $category->image) }}" alt=""
                                                    style="margin-top:10px; margin-bottom:10px; max-height: 150px;"> <br>
                                                    <!-- Old Imag Ends -->
                                                    <!-- Image Preview Area Starts -->
                                                    <img id="preview_image_container" style="margin-top:10px; margin-bottom:10px; max-height: 150px;">
                                                    <!-- Image Preview Area Ends -->
                                                    <input id="image" name="image" type="file" class="@error('image') is-invalid @enderror form-control" onchange="image_preview(event)">
                                                    @error('image')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Image Ends -->

                                            <button class="btn btn-sm btn-primary" type="submit">Save</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- Basic Form Inputs card end -->

                                <!-- Input Alignment card end -->
                            </div>
                        </div>
                    </div>
                    <!-- Page body end -->
                </div>
            </div>
            <!-- Main-body end -->
            <div id="styleSelector">

            </div>
        </div>
    </div>

    @push('script')
    <!-- Preview Image While Uploading Js Starts -->
    <script type='text/javascript'>
        function image_preview(e) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview_image_container');
                output.src = reader.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    </script>
    <!-- Preview Image While Uploading JS Ends -->
    @endpush

@endsection
