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
                <h4 class="page-title">Bids</h4>
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
                        <a href="auctions">Bids</a>
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
                                <div class="card-title">Winners</div>
                            </div>
                            <div class="card-body">

                                <table id="mytab" class="display table table-striped table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>Lot</th>
                                            <th>Name</th>
                                            <th>Bid</th>
                                            <th>DateTime</th>
                                            <th>Status</th>
                                            <!-- <th>Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($winner as $key => $value)
                                                    <tr class="@if($key % 2 == 0) odd @else even @endif">
                                                        <td ><a href="{{url('lot/edit/'.$value->enc_id)}}">{{$value->title}}</a></td>
                                                        <td>{{$value->first_name}} {{$value->last_name}}</td>
                                                        <td>£ {{$value->bid_amount}}</td>
                                                        <td>{{date('d M Y H:i:s' ,strtotime($value->created_at))}}</td>
                                                        <td>
                                                        <select class="status" name="status" id="" onchange="updatestatus(this)" data-item-id="{{$value->id}}">
                                                            <option value="won" {{($value->status == 'won' ) ? 'selected' : '' }} >Won</option>
                                                            <option value="lost" {{($value->status == 'lost' ) ? 'selected' : '' }} >Lost</option>
                                                            <option value="outbid" {{($value->status == 'outbid') ? 'selected' : '' }} >Outbid</option>
                                                            <option value="leading" {{($value->status ==  'leading') ? 'selected' : '' }} >Leading</option>
                                                            <option value="withdrawn" {{($value->status ==  'withdrawn') ? 'selected' : '' }} >Withdrawn</option>
                                                        </select>
                                                        </td>
                                                        <!-- <td></td> -->
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
@endpush

@push('scripts')

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script> -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    
    <script>

        
$(document).ready(function() {
        $('.status').select2();
    });


    function updatestatus(e) {
    var status = e.value;

    var itemId = e.getAttribute('data-item-id');

    $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{url('update-status')}}/"+itemId,
                type : 'post',
                data : {'id': itemId, 'status': status},
                success: function (data) {

                    if (data.success) {
                        var content = {};
                        content.message ='Bid Updated successfully';
                        content.title = "Bid Update";
                        
                        $.notify(content, {
                            type: 'success',
                            placement: {
                                from: 'top',
                                align: 'right',
                            },
                            time: 1000,
                            delay: 2000,
                        });
        } else {
            var content = {};
                        content.message ='Bid Updation Failed ';
                        content.title = "Bid Update Failed";
            $.notify(content, {
                            type: 'danger',
                            placement: {
                                from: 'top',
                                align: 'right',
                            },
                            time: 1000,
                            delay: 2000,
                        });
        }
    }
                    

            });
    }




    </script>
@endpush