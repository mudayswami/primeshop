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
                                <div class="card-title">Bids</div>
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
                                        @foreach ($bids as $key => $value)
                                                    <tr class="@if($key % 2 == 0) odd @else even @endif">
                                                        <td ><a href="{{url('lot/edit/'.$value->lot)}}">{{$value->title}}</a></td>
                                                        <td>{{$value->first_name}} {{$value->last_name}}</td>
                                                        <td>£ {{$value->bid_amount}}</td>
                                                        <td>{{date('d M Y H:i:s' ,strtotime($value->created_at))}}</td>
                                                        <td>
                                                        <select class="status" name="status" id="" >
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

        function approve(id) {
            if(id === null){
                alert("No id");
                return false;
            }
            
            var status = $('#approve_'+id).attr('approve');
            if(status == 0){
                approve_status = 1;

            }else{
                approve_status = 0;
            }
            $('#approve_'+id).html('...');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{url('auction-approve')}}",
                type : 'post',
                data : {'id': id, 'status': approve_status},
                success: function (result) {

                    
                    if(result == 1){
                    $('#approve_'+id).attr('approve',1);
                    $('#approve_'+id).html('Unapprove');
                    $('#badge_'+id).html('Approved');
                    $('#badge_'+id).removeClass('bg-success');
                    $('#badge_'+id).removeClass('bg-secondary');
                    $('#badge_'+id).addClass('bg-success');
                        var content = {};
                        content.message ='Auction Approved successfully';
                        content.title = "Auction Approved";
                        
                            content.icon = "fa fa-bell";
                        
                        // content.url = location.href;

                        $.notify(content, {
                            type: 'success',
                            placement: {
                                from: 'top',
                                align: 'right',
                            },
                            time: 1000,
                            delay: 0,
                        });
                    }else{
                    $('#approve_'+id).attr('approve',0);
                $('#approve_'+id).html('Approve');
                    $('#badge_'+id).html('Unapproved');
                    $('#badge_'+id).removeClass('bg-success');
                    $('#badge_'+id).removeClass('bg-secondary');
                    $('#badge_'+id).addClass('bg-secondary');
                        var content = {};
                        content.message ='Auction Unapproved Successfully';
                        content.title = "Auction Unapproved";
                        
                            content.icon = "fa fa-bell";
                        
                        // content.url = location.href;

                        $.notify(content, {
                            type: 'warning',
                            placement: {
                                from: 'top',
                                align: 'right',
                            },
                            time: 1000,
                            delay: 0,
                        });

                        
                    }
                    
                }
            });
        }
    </script>
@endpush