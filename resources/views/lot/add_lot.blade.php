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
                <h4 class="page-title">Add Lot</h4>
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
                                <div class="card-title">Add Lot</div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="add-lot" enctype="multipart/form-data">
                                    <div class="row">
                                        @csrf
                                        
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                    <label for="auction">Auction</label>
                                                    <select class="form-control" name="auction_id" id="auction_id">
                                                        <option selected disabled>select an option</option>
                                                        @foreach ($auctions as $value)
                                                                <option value="{{$value->id}}">{{$value->title}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="lot_num">Lot Number</label>
                                                <input type="text" class="form-control" name="lot_num" id="lot_num"
                                                    placeholder="">
                                            </div>
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
                                                <label for="category">Category</label>
                                                <select multiple="" class="form-control" name="category[]" id="category">
                                                    @foreach ($category as $value)
                                                            <option value="{{$value->category}}">{{$value->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="category">Condition</label>
                                                <select class="form-control" name="condition" id="category">
                                                            <option selected disabled>Select an option</option>
                                                            <option value="A">Sealed Packed Perfect Condition</option>
                                                            <option value="B">Good Condition</option>
                                                            <option value="C">Not Much Used</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="dimension">Dimesions and Weight</label>
                                                <input type="text" min="0" max="" class="form-control"
                                                    name="dimension" id="dimension" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                                <label for="start_bid">Starting Bid</label>
                                                <input step="0.1" type="number" class="form-control" name="start_bid"
                                                    id="start_bid" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="next_bid">Next Bid</label>
                                                <input step="0.1" type="number" class="form-control" name="next_bid"
                                                    id="next_bid" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="reserve_bid">Reserve Bid</label>
                                                <input step="0.1" type="number" class="form-control" name="reserve_bid"
                                                    id="reserve_bid" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="buyer_premium">Buyer's Premium</label>
                                                <input  step="0.1" type="number" min="0" max="" class="form-control"
                                                    name="buyer_premium" id="buyer_premium" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="store_price">Store Price</label>
                                                <input step="0.1" type="number" min="0" max="" class="form-control"
                                                    name="store_price" id="store_price" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            
                                            <div class="form-group">
                                                <label for="ship_info">Shipping Info</label>
                                                <input type="text" class="form-control" name="ship_info" id="ship_info"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="ship_cost">Shipping Cost</label>
                                                <input type="number" class="form-control" name="ship_cost" id="ship_cost"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="ship_restriction">Shipping Restrictions</label>
                                                <textarea class="form-control" name="ship_restriction" id="ship_restriction"
                                                    placeholder=""></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="pickup">Pickup Available</label>
                                                <select class="form-control" name="pickup" id="pickup">
                                                <option value="1">Yes</option>    
                                                <option value="0">No</option>    
                                            </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="pickup_address">Pickup Address</label>
                                                <input type="text" class="form-control" name="pickup_address" id="pickup_address"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="pickup_instruction">Pickup Instructions</label>
                                                <textarea class="form-control" name="pickup_instruction" id="pickup_instruction"
                                                    placeholder=""></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="pickup_instruction">Notes</label>
                                                <textarea class="form-control" name="notes" id="notes"
                                                    placeholder=""></textarea>
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
        $('#auction').select2();
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