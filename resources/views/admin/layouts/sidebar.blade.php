<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ URL::asset('/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
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
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <!--li-- class=""><a href="{{ url('/dashboard/categories/create') }}"><i class="fa fa-link"></i> <span>Add Category</span></a></li-->
            <li class=""><a href="{{ url('/dashboard/regions') }}"><i class="fa fa-link"></i> <span>Regions</span></a></li>


            <li class=""><a href="{{ url('/dashboard/companies') }}"><i class="fa fa-link"></i> <span>Companies</span></a></li>
            <li class=""><a href="{{ url('/dashboard/manager') }}"><i class="fa fa-link"></i> <span>Managers</span></a></li>

            <!--li-- class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Companies</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{ url('/dashboard/companies') }}">All</a></li>
                    <li><a href="{{ url('/dashboard/companies/create') }}">Create new</a></li>
                </ul>
            </li-->
            <!--li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Staff</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{ url('/dashboard/staffs') }}">All</a></li>
                    <li><a href="{{ url('/dashboard/staffs/create') }}">Create new</a></li>
                </ul>
            </li-->
            <!--li-- class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Services</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{ url('/dashboard/services') }}">All</a></li>
                    <li><a href="{{ url('/dashboard/services/create') }}">Create new</a></li>
                </ul>
            </li-->
            <li class=""><a href="{{ url('/dashboard/offices') }}"><i class="fa fa-link"></i> <span>Offices</span></a></li>
            <!--li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Offices</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li ><a href="{{ url('/dashboard/offices') }}">All</a></li>
                    <li><a href="{{ url('/dashboard/offices/create') }}">Create new</a></li>
                </ul>
            </li-->
            <li class=""><a href="{{ url('/dashboard/ads') }}"><i class="fa fa-link"></i> <span>Advertisements</span></a></li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>