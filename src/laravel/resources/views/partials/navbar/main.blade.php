<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
@include('partials.navbar.search')

<!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            @include('partials.navbar.messages')
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            @include('partials.navbar.notifications')
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('logout') }}" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>

        </li>
    </ul>
</nav>
