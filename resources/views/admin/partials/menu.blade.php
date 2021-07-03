<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <!-- <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->
    </ul>
</div>

<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">


        @if(!empty($userData))
            <li>
                <a href="{{ route('admin.logout') }}">
                    <i class="fa fa-btn fa-sign-out"></i>
                    Logout
                </a>
            </li>
        @else
            <li><a href="{{ route('admin-login') }}">Login</a></li>
        @endif
    </ul>
</div>