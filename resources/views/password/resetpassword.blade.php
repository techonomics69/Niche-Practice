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
                        <h3>Reset your password</h3>
                        {{-- <label>Enter your email address and we will send you a <br> recovery email.</label> --}}
                    </div>
                </div>
                @php
                    echo $email;
                @endphp
                <div class="response-message" style="display: none;"></div>
                <form id="passwordUpdate">
                    <input type="hidden" name="token" id="token" value="{{$token}}">
                    <div class="form-group">
                    <input type="hidden" name="email" class="form-control" id="email" placeholder="Email ID" value="{{$PasswordReset}}" data-required="true" />
                        <span class="help-block hide-me"><small></small></span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="" data-required="true" />
                        <span class="help-block hide-me"><small></small></span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password" value="" data-required="true" />
                        <span class="help-block hide-me"><small></small></span>
                    </div>   
                    <button class="btn btn-lg btn-password-update btn-block submit" name="Submit" value="password_update" type="Submit">Send</button>
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

.btn-password-update, .btn-password-update:focus {
    background-color: #01a1fe;
    color: #fff;
    font-size: 15px;
}
.btn-password-update:hover {
    background: #01a1fe;
    color:#fff;
}
</style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('public/js/login.js?ver='.$appFileVersion) }}"></script>
@endsection