<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Prime Shop</title>
    <meta content="width=device-width, initial-scale=1.0", name="viewport" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="icon" href="{{url('assets/img/logobg.png')}}" type=" image/x-icon" />
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

    <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/kaiadmin.min.css')}}" />
    <style>
        .wrapper .wrapper-login{
            background: #2a2f5bed !important;
        }
    </style>
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container-login">
            <h3>Login to Your Account</h3>
            <form action="{{url('login')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group form-sub">
                    <label class="custom-control-label">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>
                <div class="form-action">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <div class="login-account">
                <span>Don't have an account? <a href="{{url('register')}}">Register here</a></span>
            </div>
        </div>
    </div>
    <script src="{{url('assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{url('assets/js/core/popper.min.js')}}"></script>
    <script src="{{url('assets/js/core/bootstrap.min.js')}}"></script>

    <script src="{{url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="{{url('assets/js/custom-min.min.js')}}"></script>
    @stack('scripts')
</body>

</html>