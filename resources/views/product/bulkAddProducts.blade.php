@extends('layout.masterLayout')

@push('head')
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />\

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
@endpush

@push('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Add Product</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="products">Products</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <!-- <li class="nav-item">
                                                                                <a href="#">Starter Page</a>
                                                                            </li> -->
                </ul>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="page-category">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Add Products</div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('bulk-add-products')}}" enctype="multipart/form-data">
                                    <div class="row">
                                        @csrf
                                        
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="file">Upload only .xlsx | .xls</label>
                                                <input type="file" class="form-control" name="file" id="file"
                                                    accept=".xlsx, .xls" placeholder="">
                                            </div>
                                            <div class="row">
                                                <div class="form-group text-center">
                                                    <button class="btn btn-success" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                                <div class="form-group col-lg-4">
                                    <label class="h1" for="file">Check this dummy File</label>
                                    <a class="form-control h3"
                                        href="{{url('storage/products/buy_now.xlsx')}}"><u><b>Demo File</b></u></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#category').select2();
        });
        function valid(e) {
            e.preventDefault();
            const title = $('#title').val();
            const description = $('#description').val();
            const img = $('#img').val();
            const start = $('#start_date').val();
            const end = $('#end_date').val();
            const type = $('#type').val();
            const category = $('#category').val();
            const products = $('#products').val();
        }
    </script>
@endpush