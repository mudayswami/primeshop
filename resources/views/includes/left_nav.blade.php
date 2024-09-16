<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="{{url('assets/img/logobg.png')}}" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Auction</h4>
                </li>
                <li class="nav-item d-none">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fas fa-layer-group"></i>
                        <p>Home Page</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="#">
                                    <span class="sub-item">Upcoming Auction</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Our top Category</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Upcoming Auction</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarLayouts">
                        <i class="fas fa-th-list"></i>
                        <p>Auctions</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{url('auction-list')}}">
                                    <span class="sub-item">Auction Listing</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('add-auction')}}">
                                    <span class="sub-item">Add Auction</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('bulk-upload-auction')}}">
                                    <span class="sub-item">Add Bulk Auction</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#category-listing">
                        <i class="fas fa-th-list"></i>
                        <p>Auction Category</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="category-listing">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{url('add-auction-category')}}">
                                    <span class="sub-item">Add Category / Listing </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#forms">
                        <i class="fas fa-pen-square"></i>
                        <p>Lot</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{url('add-lot')}}">
                                    <span class="sub-item">Add Lot</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('bulk-upload-lots')}}">
                                    <span class="sub-item">Add Bulk Lots</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('lot-list')}}">
                                    <span class="sub-item">Lots Listing</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#product">
                        <i class="fas fa-th-list"></i>
                        <p>Product</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="product">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{url('product-list')}}">
                                    <span class="sub-item">Products Listing</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('add-product')}}">
                                    <span class="sub-item">Add Product</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('bulk-upload-product')}}">
                                    <span class="sub-item">Add Bulk Product</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#tables">
                        <i class="fas fa-table"></i>
                        <p>Bidding</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{url('approve-bidding')}}">
                                    <span class="sub-item">Bidding Approval Requests</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{url('bids')}}">
                                    <span class="sub-item">Bids</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Winners</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Access Management</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#maps">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Admin</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="maps">
                        <ul class="nav nav-collapse" id="sidebar-links">
                            <li>
                                <a href="{{url('register/signup')}}">
                                    <span class="sub-item">Add admin user</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('admin-users')}}">
                                    <span class="sub-item">Admin users</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#charts">
                        <i class="far fa-chart-bar"></i>
                        <p>User</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav nav-collapse" id="sidebar-links">
                            <li>
                                <a href="{{url('allusers')}}">
                                    <span class="sub-item">Users</span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="#">
                                    <span class="sub-item">New Users</span>
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>