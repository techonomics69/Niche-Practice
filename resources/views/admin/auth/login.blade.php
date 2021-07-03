@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
            <div class="box box-default">
                <div class="box-header with-border">
{{--                    <div class="box-title" v-text="title"></div>--}}
                    <div class="box-title">@{{ title }}</div>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('post-login') }}" @submit="checkForm">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <div class="col-md-12">
                                @if (session('message'))
                                    <div class="alert {{ (session('messageCode') != 200) ? 'alert-danger' : 'alert-success' }}">
                                        {{ session('message') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Email Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" v-model="email" />

                                <span v-if="errors.email" class="help-block error">
                                    <small>@{{ errors.email }}</small>
                                </span>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" v-model="password" />

                                <span v-if="errors.password" class="help-block error">
                                    <small>@{{ errors.password }}</small>
                                </span>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-md-offset-4">--}}
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input type="checkbox" name="remember"> Remember me--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('after_styles')
    <style>
    .content-wrapper
    {
        margin-left: 0;
    }
    .skin-purple .wrapper {
        background-color: #ecf0f5;
    }
    .sidebar-toggle
    {
        display: none;
    }
    </style>
@endsection

@section('js')
<script>
    var app = new Vue({
        el: '#napp',
        data: {
            errors:[],
            email:null,
            password:null,
            hidden: false,
            title: 'Login',
            message: 'Hello Vue!',
            content: 'Hi Content',
            menu: "wow",
            items: [
                'one',
                'two'
            ],
            price: 100,
            // tax1: this.price * 0.1
        },
        methods:{
            checkForm:function(e) {
                this.errors = [];
                if(this.email && this.password) return true;
                if(!this.email)
                {
                    console.log("this name");
                    console.log(this.email);
                    this.errors.email = "Email is required.";
                    // checkState();
                }
                if(!this.password)
                {
                    console.log("this name");
                    console.log(this.password);
                    this.errors.password = "Password is required.";
                    // checkState();
                }
                // if(!this.name) this.errors.push("Name required.");
                // if(!this.age) this.errors.push("Age required.");
                // alert("hi");

                e.preventDefault();
            }
        },
        computed:
            {
                tax: function () {
                    return this.price * 0.1
                }
            }
    })
</script>
@endsection
