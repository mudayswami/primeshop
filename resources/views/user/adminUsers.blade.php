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
                <h4 class="page-title">Users</h4>
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
                        <a href="{{url('dashboard')}}">dashboard</a>
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
                                <div class="card-title">Users </div>
                            </div>
                            <div class="card-body">

                                <table id="mytab" class="display table table-striped table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $value)
                                                    <tr class="@if($key % 2 == 0) odd @else even @endif">
                                                        
                                                        <td>{{$value->id}}</td>
                                                        <td>{{$value->first_name}} </td>
                                                        <td>{{$value->last_name}}</td>
                                                        <td>{{$value->email}}</td>
                                                        <td>
                                                            <!-- <a href="{{url('user/edit/'.$value['enc_id'])}}"><div class="btn btn-primary btn-sm">Edit</div></a> -->
                                                             <a id="del_{{$value['id']}}" onclick="del({{$value['id']}})"><div class="btn btn-sm btn-danger">Delete</div></a></td>
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
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                buttons: {
                    cancel: {
                        visible: true,
                        text: "No, cancel!",
                        className: "btn btn-danger",
                    },
                    confirm: {
                        text: "Yes, delete it!",
                        className: "btn btn-success",
                    },
                },
            }).then((willDelete) => {
                if (willDelete) {
                    var id = e;
                    if (id == null) {
                        alert("No id");
                        return false;
                    }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('delete-admin')}}",
                    type: 'post',
                    data: {'id':id},
                    success: function (result) {


                        if (result == 1) {
                            var content = {};
                            content.message = 'User Deleted successfully';
                            content.title = "User Delete";

                            content.icon = "fa fa-bell";

                            content.url = location.href;

                            $.notify(content, {
                                type: 'success',
                                placement: {
                                    from: 'top',
                                    align: 'right',
                                },
                                time: 1000,
                                delay: 2000,
                            });

                            var button = document.getElementById('del_' + id);
                            var parentRow = button.closest('tr');

                            if (parentRow) {
                                parentRow.classList.add('d-none');
                            } else {
                                console.log('No parent <tr> found');
                            }
                        } else {
                            var content = {};
                            content.message = 'No user Found';
                            content.title = "Delete user";

                            content.icon = "fa fa-bell";

                            content.url = location.href;

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
        
                } else {
                    
                }
            });
        }
    </script>
@endpush