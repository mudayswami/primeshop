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
                <h4 class="page-title">Product</h4>
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
                        <a href="auctions"></a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <!-- <li class="nav-item">
                                                                            <a href="#">Starter Page</a>
                                                                        </li> -->
                </ul>
            </div>
            <div class="page-category">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Edit Product</div>@if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('update-product').'/'.$product->id}}" enctype="multipart/form-data">
                                    <div class="row">
                                        @csrf
                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="brand">Brand</label>
                                                <input type="text" class="form-control" name="brand" id="brand" placeholder="" value="{{$product->brand}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" name="title" id="title" value="{{$product->title}}"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description"
                                                    aria-label="With textarea" rows="3">{{$product->description}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="img">Image</label>
                                                <input type="file" class="form-control" name="img" id="img" placeholder="" value="">
                                                @if(isset($product->img))
                                                <input type="text"  value="{{$product->img}}" name="img" >
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="option">Options</label>
                                                <textarea class="form-control" id="option" name="option"
                                                    aria-label="With textarea" rows="3">{{($product->options)}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <select multiple="" class="form-control" name="department[]"
                                                    id="department">
                                                    @foreach ($category as $value)
                                                        <option value="{{$value->category}}"  {{in_array($value->category, json_decode($product->department)) ? 'selected' : ''}}>{{$value->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="category">Condition</label>
                                                <select class="form-control" name="condition" id="category">
                                                    <option selected disabled>Select an option</option>
                                                    <option {{$product->condition == 'A' ? 'selected' : '' }} value="A">Sealed Packed Perfect Condition</option>
                                                    <option {{$product->condition == 'B' ? 'selected' : '' }} value="B">Good Condition</option>
                                                    <option {{$product->condition == 'C' ? 'selected' : '' }} value="C">Not Much Used</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="original_price">Original Price</label>
                                                <input step="0.01" type="number" class="form-control" name="original_price" value="{{$product->original_price}}"
                                                    id="original_price" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="discount_price">Discount Price</label>
                                                <input step="0.1" type="number" class="form-control" name="discount_price" value="{{$product->discount_price}}"
                                                    id="discount_price" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="discount_percentage">Discount Percentage</label>
                                                <input step="0.1" type="number" class="form-control" value="{{$product->discount_percentage}}"
                                                    name="discount_percentage" id="discount_percentage" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="stock">Stock</label>
                                                <input step="0.1" type="number" min="0" max="" class="form-control" value="{{$product->stock}}"
                                                    name="stock" id="stock" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="featured">Featured</label>
                                                <input type="number" min="0" max="" class="form-control" value="{{$product->featured}}"
                                                    name="featured" id="featured" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group text-center">
                                                <button class="btn btn-success"  type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
            $('#auction').select2();
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