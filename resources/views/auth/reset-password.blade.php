@extends('master')

@section('pageTitle', 'Reset Password')

@section('js')
    <script type="text/javascript" src="{{ asset('public/admin/task/custom-validation.js') }}"></script>
@endsection

@section('content')
    <section class="new-login-register">
        {{--<div class="lg-info-panel">
            <div class="inner-panel">
                <div class="lg-content">
                </div>
            </div>
        </div>--}}

        <div class="new-login-box">
            <div class="logo-logo"><img src="{{ asset('public/images/logo-login.png') }}" alt=""></div>
            <div class="white-box">
                <form class="form-horizontal validate-me" role="form" method="POST" action="{{ route('reset-password') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="login-heading">
                                <h3 class="box-title m-b-0">Recover Password</h3>
                            </div>
                        </div>
                        @if (session('message'))
                            <div class="col-md-12 response-message">
                                <div class="m-b-0 alert {{ (session('messageCode') != 200) ? 'alert-danger' : 'alert-success' }}">
                                    {{ session('message') }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group  m-t-20 {{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                            <input type="password" placeholder="New Password" class="form-control" id="password" name="password" value="" data-required="true" />
                            <span class="help-block {{ $errors->has('password') ? ' error' : 'hide-me' }}">
                                <small>{{ $errors->first('password') }}</small>
                            </span>
                        </div>
                    </div>

                    <div class="form-group  m-t-20 {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                        <input type="password" placeholder="Confirm Password" class="form-control" id="password-confirm" name="confirm_password" value="" data-required="true" />
                        <span class="help-block {{ $errors->has('confirm_password') ? ' error' : 'hide-me' }}">
                                <small>{{ $errors->first('confirm_password') }}</small>
                            </span>
                    </div>
                    </div>

                    <input type="hidden" name="token" value="{{ (!empty($_GET['token'])) ? $_GET['token'] : '' }}" />

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block waves-effect waves-light" type="submit">Change Password</button>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <a href="{{ route('login') }}" class="text-dark">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
