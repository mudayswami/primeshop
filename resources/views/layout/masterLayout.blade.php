<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Prime Shop</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="icon" href="{{url('assets/img/logobg.png')}}"" type=" image/x-icon" />
    <!-- Fonts and icons -->
    <script src="{{url('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{url('assets/css/fonts.min.css')}}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/kaiadmin.min.css')}}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!-- <link rel="stylesheet" href="{{url('assets/css/demo.css')}}" /> -->
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('includes.left_nav')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('includes.top_nav')

            @stack('content')
            @include('includes.footer')
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{url('assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{url('assets/js/core/popper.min.js')}}"></script>
    <script src="{{url('assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Chart JS -->
    <!-- <script src="{{url('assets/js/plugin/chart.js/chart.min.js')}}"></script> -->

    <!-- jQuery Sparkline -->
    <!-- <script src="{{url('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script> -->

    <!-- Chart Circle -->
    <!-- <script src="{{url('assets/js/plugin/chart-circle/circles.min.js')}}"></script> -->

    <!-- Datatables -->
    <!-- <script src="{{url('assets/js/plugin/datatables/datatables.min.js')}}"></script> -->

    <!-- Bootstrap Notify -->
    <script src="{{url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    <!-- jQuery Vector Maps -->
    <!-- <script src="{{url('assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script> -->
    <!-- <script src="{{url('assets/js/plugin/jsvectormap/world.js')}}"></script> -->

    <!-- Google Maps Plugin -->
    <!-- <script src="{{url('assets/js/plugin/gmaps/gmaps.js')}}"></script> -->

    <!-- Sweet Alert -->
    <script src="{{url('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{url('assets/js/custom-min.min.js')}}"></script>
    <script>
        function filterSidebar() {
            let searchInput = document.getElementById('sidebar-search-input').value.toLowerCase();
            let sidebarLinks = document.querySelectorAll('li.nav-item');
            sidebarLinks.forEach(function (link) {
                let linkText = link.textContent.toLowerCase();
                console.log(link);
                if (linkText.includes(searchInput)) {
                    link.style.display = '';
                } else {
                    link.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            let currentUrl = window.location.href;
            let sidebarLinks = document.querySelectorAll(' ul.nav-collapse li');
            sidebarLinks.forEach(function (li) {
                let link = li.querySelector('a');

                if (link && link.href === currentUrl) {
                    console.log(link.href);
                    li.classList.add('active');
                    let parentNavItem = li.closest('li.nav-item');
                    if (parentNavItem) {
                        parentNavItem.classList.add('active', 'submenu');
                    }
                    let parentCollapse = li.closest('.collapse');
                    if (parentCollapse) {
                        parentCollapse.classList.add('show');
                        parentCollapse.classList.remove('collapse');
                    }
                }
            });
        });

    </script>
    @stack('scripts')
</body>

</html>