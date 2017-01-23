<div class="header clearfix">
    <nav>
        <ul class="nav nav-pills pull-right">
            @if(Sentinel::check())
                <li role="presentation">
                    <form method="POST" action="{{url('/logout')}}" id="logout-form">
                        {{csrf_field()}}
                        <a href="#" onclick="logout()">Logout</a>
                    </form>
                </li>
                @else
                <li role="presentation"><a href="{{url('/login')}}">Login</a></li>
                <li role="presentation"><a href="{{url('/register')}}">Register</a></li>
                @endif


        </ul>
    </nav>
    @if(Sentinel::check())
        hello {{Sentinel::getUser()->first_name}}
    @else
        <h3 class="text-muted">Authentication with sentinel</h3>
    @endif

</div>
<script>
    function logout(){
        document.getElementById('logout-form').submit();
    }
</script>