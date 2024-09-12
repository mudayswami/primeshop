@extends('layout.masterLayout')

@push('head')
@endpush

@push('styles')
@endpush

@push('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
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
                                <div class="card-title">Add Category</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @csrf
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <input type="text" class="form-control" name="category" id="category"
                                                placeholder="">
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-success" type="button" id="add_category">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Category Listing</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table id="category-list" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($category as $key => $value)
                                                <tr>
                                                    <form action="{{url('update-category').'/'.$value->id}}" method="post">
                                                        @csrf
                                                    <td>{{$key + 1}}</td>
                                                    <td><input name="category" value="{{$value->category}}"/></td>
                                                    <td>@if($value->status==1)<span class="badge rounded-pill bg-success">Active</span>@else <span class="badge rounded-pill bg-danger">Inactive</span>
                                                    @endif</td>
                                                    <td><button class="btn btn-success" type="submit" id="">Update</button>
                                                    <a href="{{url('delete-category').'/'.$value->id}}"><button class="btn btn-danger" type="button" id="">Delete</button></a>
                                                </td>
                                                </form>
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
    </div>
@endpush

@push('scripts')
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <script>
        function valid(e) {
            e.preventDefault();
            const title = $('#title').val();
            const description = $('#description').val();
            const img = $('#img').val();
            const start = $('#start_date').val();
            const end = $('#end_date').val();
            const type = $('#type').val();
            const category = $('#category').val();
            const lots = $('#lots').val();
        }

        $("#add_category").click(function (e) {
            var title = $("#category").val();
            if (title.trim() == '') {
                return false;
            }
            $("#add_category").val('<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('add-auction-category') }}",
                data: { 'title': title },
                type: 'post',
                success: function (result) {

                    console.log("===== " + result + " =====");
                    $("#category").val("");
                    // $("#displayNotif").on("click", function () {
                    var content = {};
                        content.message ='Category is added successfully';
                        content.title = "Category Added";
                        
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
                        location.href =location.href;
                    // });
                }
            });
        });
        $(document).ready(function () {
            $("#category-list").DataTable({});
        });
    </script>
@endpush