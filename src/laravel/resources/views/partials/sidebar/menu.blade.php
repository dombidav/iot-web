<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
                Dashboard
                {{--<span class="right badge badge-danger">New</span>--}}
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
                Users
                {{--<span class="right badge badge-danger">New</span>--}}
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
                Devices
                {{--<span class="right badge badge-danger">New</span>--}}
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
                Log
                {{--<span class="right badge badge-danger">New</span>--}}
            </p>
        </a>
    </li>
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
                ACS
                <i class="fas fa-angle-left right"></i>
                {{--                                <span class="badge badge-info right">6</span>--}}
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Workers</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Locks</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages/layout/boxed.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Groups</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Access Log</p>
                </a>
            </li>
        </ul>
    </li>
</ul>
