@extends('index')

@section('pageTitle', 'Forgot Password')

@section('content')
    <div class="container">
        <div class="wrapper login-page">
            <div class="form-signin">
                <div class="login-top">
                    <div class="login-logo">
                        <img align="NichePractice" src="{{ asset('public/images/logo-register.png') }}" class="logo">
                    </div>
                    <div class="welcome-heading">
                        <h3>Forgot your password?</h3>
                        <label>Enter your email address and we will send you a <br> recovery email.</label>
                    </div>
                </div>

                
                <form id="forgot-pass">
                    <div class="response-message" style="display: none;"></div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" placeholder="Email ID" data-required="true" />
                        <span class="help-block hide-me"><small></small></span>
                    </div>
    
                    <button class="btn btn-lg btn-forgot btn-block submit" name="Submit" value="forget" type="Submit">Send</button>
    
                </form>

                <label class="label-footer">
                    <a href="{{ route('login') }}">Return to Login</a>
                </label>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>

.btn-forgot, .btn-forgot:focus {
    background-color: #01a1fe;
    color: #fff;
    font-size: 15px;
}
.btn-forgot:hover {
    background: #01a1fe;
    color:#fff;
}
</style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/js/login.js?ver='.$appFileVersion) }}"></script>
@endsection