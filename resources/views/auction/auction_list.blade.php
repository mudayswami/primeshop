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
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Type</th>
                                            <th>Category</th>
                                            <th>Lots</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($auctions as $key => $value)
                                                    <tr class="@if($key % 2 == 0) odd @else even @endif">
                                                        <td>{{$value->title}}</td>
                                                        <td>
                                                            @if($value->status == 1)<span class="badge rounded-pill bg-success">Active</span>@else <span class="badge rounded-pill bg-danger">Inactive</span>@endif
                                                            @if($value->end_date < date('Y-m-d H:i:s'))<span class="badge rounded-pill bg-danger">Expired</span>@elseif($value->start_date > date('Y-m-d H:i:s') && $value->end_date < date('Y-m-d H:i:s')) <span class="badge rounded-pill bg-success">Live</span>@else <span class="badge rounded-pill bg-warning text-dark">Upcoming</span> @endif
                                                        </td>
                                                        <td>{{$value->start}}</td>
                                                        <td>{{$value->end}}</td>
                                                        <td>{{$value->type}}</td>
                                                        <td>{{$value->category}}</td>
                                                        <td>{{$value->lots}}</td>
                                                        <td><a href="{{url('auction/edit/'.$value->id)}}"><div class="btn btn-primary btn-sm">Edit</div></a> <a id="del_{{$value->id}}" onclick="del({{$value->id}})"><div class="btn btn-sm btn-danger">Delete</div></a></td>
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

        function del(e) {
                var id = e;
            if(id == null){
                alert("No id");
                return false;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{url('delete-auction')}}"+"/"+id,
                type: 'post',
                success: function (result) {

                    
                    if(result == 1){
                        var content = {};
                        content.message ='Auction Deleted successfully';
                        content.title = "Delete Auction";
                        
                            content.icon = "fa fa-bell";
                        
                        content.url = location.href;

                        $.notify(content, {
                            type: 'success',
                            placement: {
                                from: 'top',
                                align: 'right',
                            },
                            time: 1000,
                            delay: 0,
                        });

                        var button = document.getElementById('del_'+id);
                        var parentRow = button.closest('tr');

                        if (parentRow) {
                            parentRow.classList.add('d-none');
                        } else {
                            console.log('No parent <tr> found');
                        }
                    }else{
                        var content = {};
                        content.message ='No auction Found';
                        content.title = "Delete Auction";
                        
                            content.icon = "fa fa-bell";
                        
                        content.url = location.href;

                        $.notify(content, {
                            type: 'danger',
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