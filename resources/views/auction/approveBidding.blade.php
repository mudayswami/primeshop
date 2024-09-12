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
                <h4 class="page-title">Auctions</h4>
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
                                <div class="card-title">Auctions </div>
                            </div>
                            <div class="card-body">

                                <table id="mytab" class="display table table-striped table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>Auction</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Name</th>
                                            <th>Requested at</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($auction as $key => $value)
                                                    <tr class="@if($key % 2 == 0) odd @else even @endif">
                                                        <a><td href="{{url('auction/edit/'.$value->auction_id)}}">{{$value->title}}</a></td>
                                                        <td>{{date('d M Y H:i:s' ,strtotime($value->start))}}</td>
                                                        <td>{{date('d M Y H:i:s' ,strtotime($value->end))}}</td>
                                                        <td>{{$value->first_name}} {{$value->last_name}}</td>
                                                        <td>{{date('d M Y H:i:s' ,strtotime($value->created_at))}}</td>
                                                        <td>
                                                            @if($value->approved == 0)<span class="badge rounded-pill bg-secondary" id="badge_{{$value->id}}">Unapproved</span>@elseif($value->approved == 1) <span class="badge rounded-pill bg-success" id="badge_{{$value->id}}">Approved @endif
                                                        </td>
                                                        <td><div class="btn btn-primary btn-sm" id="approve_{{$value->id}}" approve="{{$value->approved}}" onclick="approve({{$value->id}})">@if($value->approved == 0) Approved @elseif($value->approved == 1) Unapproved @endif</div> </td>
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
    
    <script>

        $(document).ready(function () {
            $("#mytab").DataTable({});
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
                            delay: 2000,
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
                            delay: 2000,
                        });

                        
                    }
                    
                }
            });
        }
    </script>
@endpush