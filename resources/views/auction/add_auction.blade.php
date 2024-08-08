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
                <h4 class="page-title">Add Auction</h4>
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
                        <a href="auctions">Auctions</a>
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
                                <div class="card-title">Add Auction</div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="add-auction" enctype="multipart/form-data">
                                    <div class="row">
                                        @csrf
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" name="title" id="title"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description"
                                                    aria-label="With textarea" rows="3"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="img">Image</label>
                                                <input type="file" class="form-control" name="img" id="img" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="datetime-local" class="form-control" name="start_date"
                                                    id="start_date" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="datetime-local" class="form-control" name="end_date"
                                                    id="end_date" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">

                                            <div class="form-group">
                                                <label for="type">Type</label>
                                                <input type="text" class="form-control" name="type" id="type"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select multiple="" class="form-control" name="category[]" id="category">
                                                    @foreach ($category as $value)
                                                            <option value="{{$value->category}}">{{$value->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="lots">Lots</label>
                                                <input type="number" class="form-control" name="lots" id="lots"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="terms">Terms & Conditions</label>
                                                <textarea class="form-control" id="terms" name="terms"
                                                    aria-label="With textarea" rows="3"></textarea>
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="buyer_premium">Buyer's Premium</label>
                                                <input type="number" min="0" max="100" class="form-control"
                                                    name="buyer_premium" id="buyer_premium" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="seller_premium">Seller's Premium</label>
                                                <input type="number" class="form-control"
                                                    name="seller_premium" id="seller_premium" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="buyer_premium">Other Fees</label>
                                                <input type="number" class="form-control" name="fees" id="fees"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="vat">VAT Rate</label>
                                                <input type="number" class="form-control" name="vat" id="vat"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="vat">Other Taxes</label>
                                                <input type="number" class="form-control" name="taxes" id="taxes"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group text-center">
                                                <button class="btn btn-success" type="submit">Submit</button>
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
        $(document).ready(function() {
        $('#category').select2();
    });
        function valid(e) {
            e.preventDefault();
            const title         = $('#title').val();
            const description   = $('#description').val();
            const img           = $('#img').val();
            const start         = $('#start_date').val();
            const end           = $('#end_date').val();
            const type          = $('#type').val();
            const category      = $('#category').val();
            const lots          = $('#lots').val();
        }
    </script>
@endpush