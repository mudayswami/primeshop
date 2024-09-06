@extends('layout.masterLayout')

@push('head')
@endpush

@push('styles')
@endpush

@push('content')
<div class="login">
        <div class="wrapper wrapper-login">
            <div class="container-login">
                <h3>Login</h3>
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <span class="show-password">👁️</span>
                    </div>

                    <div class="form-sub">
                        <label class="custom-control-label">Remember me</label>
                        <input type="checkbox" name="remember">
                    </div>

                    <div class="form-action">
                        <button type="submit" class="btn-login">Login</button>
                    </div>

                    <div class="login-account">
                        <p>Don't have an account? <a href="#">Sign up here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endpush

@push('scripts')
@endpush