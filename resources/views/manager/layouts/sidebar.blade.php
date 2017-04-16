<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ URL::asset('/img/user.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>
                    @if(Sentinel::check())
                        {{Sentinel::getUser()->first_name}} {{Sentinel::getUser()->last_name}}
                    @endif
                </p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <!--form-- action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header"></li>
            <!-- Optionally, you can add icons to the links -->
            <!--li-- class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Staff</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{ url('/manager/staffs') }}">All</a></li>
                    <li><a href="{{ url('/manager/staffs/create') }}">Create new</a></li>
                </ul>
            </li-->
            <!--li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Ticket Windows</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{ url('/manager/ticket_windows') }}">All</a></li>
                    <li><a href="{{ url('/manager/ticket_windows/create') }}">Create new</a></li>
                </ul>
            </li-->
            <!--li-- class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Tickets</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{url('/manager/tickets')}}">All</a></li>
                    <li><a href="#"></a></li>
                </ul>
            </li-->
            <li class=""><a href="{{ url('/manager/staffs') }}"><i class="fa fa-users"></i> <span>Staff members</span></a></li>
            <li class=""><a href="{{ url('/manager/ticket_windows') }}"><i class="fa fa-link"></i> <span>Ticket Windows</span></a></li>
            <li class=""><a href="{{url('/manager/tickets')}}"><i class="fa fa-ticket"></i> <span>Tickets</span></a></li>
            <li class=""><a href="{{url('/manager/services')}}"><i class="fa fa-thumbs-up"></i> <span>Services</span></a></li>

            <!--li class=""><a href="#"><i class="fa fa-link"></i> <span>Request Services</span></a></li-->
            <li class="treeview">
                <a href="#"><i class="fa fa-area-chart"></i> <span>Statistics</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{url('/manager/statistics/services')}}">Services</a></li>
                    <li><a href="#"></a></li>
                </ul>
            </li>

            <li class=""><a href="{{url('/manager/basicConfiguration')}}"><i class="fa fa-cogs"></i> <span>Office Config</span></a></li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>